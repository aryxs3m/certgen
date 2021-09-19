<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CertController extends Controller
{

    public function makeCert(Request $request)
    {
        $validated = $request->validate([
            'filename' => 'required|string',
            'keysize' => 'required|integer|min:128',
            'country' => 'required|string|size:2',
            'state' => 'required|string',
            'location' => 'required|string',
            'organization' => 'required|string',
            'orgunit' => 'required|string',
            'commonname' => 'required|string',
            'email' => 'required|email',
            'days' => 'required|integer|min:1',
            'password' => 'required|string'
        ]);

        $filename = storage_path($validated['filename']);
        $caPemFile = storage_path('pvga_ca.pem');
        $caKeyFile = storage_path('pvga_ca.key');
        $extFile = storage_path('csr_part_ext.ext');

        // generating key
        shell_exec("openssl genrsa -out \"{$filename}.key\" {$validated['keysize']}");

        // generating csr
        shell_exec("openssl req -new -key \"{$filename}.key\" -subj req -new -out \"{$filename}.csr\" -subj \"/C={$validated['country']}/ST={$validated['state']}/L={$validated['location']}/O={$validated['organization']}/OU={$validated['orgunit']}/CN={$validated['commonname']}/emailAddress={$validated['email']}\"");

        // generating cert
        $tempExtFile = tempnam('/tmp', 'extfile');
        file_put_contents($tempExtFile, file_get_contents($extFile) . "\n[alt_names]\nDNS.1 = {$validated['commonname']}");
        $tempExtFileEscape = escapeshellarg($tempExtFile);

        exec("openssl x509 -req -in \"{$filename}.csr\" -CA \"{$caPemFile}\" -CAkey \"{$caKeyFile}\" -CAcreateserial -out \"{$filename}.crt\" -days {$validated['days']} -sha256 -extfile {$tempExtFileEscape} -passin pass:{$validated['password']}");

        unlink($tempExtFile);

        $zip_file = $validated['filename'] . '_cert.zip';

        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $fileCert = "{$validated['filename']}.crt";
        $zip->addFile(storage_path($fileCert), $fileCert);

        $fileCsr = "{$validated['filename']}.csr";
        $zip->addFile(storage_path($fileCsr), $fileCsr);

        $fileKey = "{$validated['filename']}.key";
        $zip->addFile(storage_path($fileKey), $fileKey);

        $zip->close();

        unlink(storage_path($fileCert));
        unlink(storage_path($fileCsr));
        unlink(storage_path($fileKey));

        return response()->download($zip_file);
    }

}
