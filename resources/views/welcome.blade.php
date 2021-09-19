<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="aryxs3m">
    <title>Cert generator</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <h2 class="mt-5">Cert generator</h2>

    <form action="/" method="post">
        @csrf
        <div class="mb-3">
            <label for="fileName" class="form-label">Filename</label>
            <input type="text" class="form-control" id="fileName" name="filename" placeholder="server.domain.lan">
            <small>Extensions will be appended to the filename (key, crt, csr, etc.)</small>
        </div>

        <h4>Key</h4>
        <div class="mb-3">
            <label for="keySize" class="form-label">Key size</label>
            <input type="number" class="form-control" id="keySize" name="keysize" value="2048">
        </div>

        <h4>CSR</h4>
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <input type="text" class="form-control" id="country" name="country" value="HU">
        </div>
        <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <input type="text" class="form-control" id="state" name="state" value="Bacs-Kiskun">
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="Kecskemet">
        </div>
        <div class="mb-3">
            <label for="organization" class="form-label">Organization</label>
            <input type="text" class="form-control" id="organization" name="organization" value="PVGA">
        </div>
        <div class="mb-3">
            <label for="organizational_unit" class="form-label">Organizational Unit</label>
            <input type="text" class="form-control" id="organizational_unit" name="orgunit" value="PVGA HQ Kecskemet">
        </div>
        <div class="mb-3">
            <label for="common_name" class="form-label">Common Name</label>
            <input type="text" class="form-control" id="common_name" name="commonname" placeholder="server.domain.lan">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="mail@example.com">
        </div>

        <h4>Certificate</h4>
        <div class="mb-3">
            <label for="days" class="form-label">Valid until (days)</label>
            <input type="number" class="form-control" id="days" name="days" value="365">
        </div>

        <h4>CA passphrase</h4>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>

        <button type="submit" class="btn btn-primary">Generate</button>
    </form>
</div>

</body>
</html>
