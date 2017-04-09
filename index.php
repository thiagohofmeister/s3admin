<?php

$scheme = $_SERVER['REQUEST_SCHEME'];
if (empty($scheme)) {
    $scheme = $_SERVER['HTTP_X_FORWARDED_PROTO'];
}
define('PATH_WEB', dirname($scheme . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']));

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Leonardo Oliveira <leonardo.malia@live.com>">

    <title>S3 Admin</title>

    <link href="web/css/bootstrap.min.css" rel="stylesheet">
    <link href="web/css/bootstrap-theme.min.css" rel="stylesheet">

</head>

<body>

<input type="hidden" id="connectionId" value="">

<div class="modal fade" id="authenticate" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="authenticate-modal-name">Authentication</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="key">Key</label>
                    <input type="text" class="form-control" id="key" placeholder="Key">
                </div>
                <div class="form-group">
                    <label for="secret">Secret</label>
                    <input type="text" class="form-control" id="secret" placeholder="Secret">
                </div>

                <div class="form-group">
                    <label for="secret">Region</label>
                    <select class="form-control" id="region">
                        <option value="">Select</option>
                        <option value="us-east-1">us-east-1</option>
                        <option value="us-east-2">us-east-2</option>
                        <option value="us-west-1">us-west-1</option>
                        <option value="us-west-2">us-west-2</option>
                        <option value="ca-central-1">ca-central-1</option>
                        <option value="ap-south-1">ap-south-1</option>
                        <option value="ap-northeast-2">ap-northeast-2</option>
                        <option value="ap-southeast-1">ap-southeast-1</option>
                        <option value="ap-southeast-2">ap-southeast-2</option>
                        <option value="ap-northeast-1">ap-northeast-1</option>
                        <option value="eu-central-1">eu-central-1</option>
                        <option value="eu-west-1">eu-west-1</option>
                        <option value="eu-west-2">eu-west-2</option>
                        <option value="sa-east-1">sa-east-1</option>
                    </select>
                </div>
            </div>
            <input type="hidden" class="form-control" id="identifier" value="">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="registerAuthenticate">Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                <button type="button" class="btn btn-success" id="connect" style="display: none">Connect <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></button>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Amazon S3 Admin</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Authentications<span class="caret"></span></a>
                    <ul class="dropdown-menu" id="dropdown-authentications">
                        <li><a href="#" id="modal-new-authentication">New</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">All endorsements</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container theme-showcase" role="main"  style="margin-top: 40px;">

    <div class="page-header">
        <h1>Files</h1>
    </div>

    <div class="input-group">
        <div class="input-group-addon" id="bucket">-</div>
        <input type="text" class="form-control" id="path" placeholder="Path" value="">
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>File</th>
                    <th>Last modified</th>
                    <th>Size</th>
                </tr>
                </thead>
                <tbody id="body-files">

                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="web/js/jquery.js"></script>
<script>
    var BASE_PATH = '<?=PATH_WEB?>';
</script>
<script src="web/js/bootstrap.min.js"></script>
<script src="web/js/main.js"></script>

</body>
</html>