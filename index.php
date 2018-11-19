<?PHP
include("vendor/autoload.php");
include("src/DB.php");
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

if ($_GET['action']=='deleteFile' && is_numeric($_GET['image_id'])){
    $info=getData($_GET['image_id']);

    $sql = "delete from images where image_id = :image_id";
    $stmt = DB::prepare($sql);
    $stmt->bindValue(':image_id', $_GET['image_id'], PDO::PARAM_INT);
    $stmt->execute();

    @unlink("src/files/thumbs/{$info['filepath']}");
    @unlink("src/files/{$info['filepath']}");
    $ret['success']=true;
    echo json_encode($ret);
    exit();
}

if ($_GET['action']=='getFiles'){
    $ret['success']=true;
    $sql = "select * from images order by created_at DESC";
    $stmt = DB::prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    
    if ($rows){
        foreach ($rows as $key => $row) {
            $ret['html'] .= <<<EOL
              <div class="col-sm-6 col-md-4" id="placeholder_{$row['image_id']}">
                <div class="thumbnail">
                  <img src="src/files/thumbs/{$row['filepath']}" title="{$row['filepath']}" class='group1' href="src/files/{$row['filepath']}" style="cursor:pointer;">
                  <div class="caption">
                    <h3>{$row['filepath']}</h3>
                    <a href="#" class="btn btn-danger" role="button" onclick="javascript:Delete({$row['image_id']})">Delete</a></p>
                  </div>
                </div>
              </div>
EOL;
        }
    } else {
      
    }
    echo json_encode($ret);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/jquery.fileupload.css">
    <link rel="stylesheet" href="assets/colorbox.css">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class='container-fluid'>
    <h1>File Gallery and upload</h1>

    <div class="alert alert-info" role="alert">
        <b>Tips:</b>
        <ul>
            <li>You can drop any image in this page, and it will be automatically uploaded</li>
            <li>You can upload multiple files</li>
            <li>After delete confirmation, the files are erased from the disk and the database</li>
            <li>Click on the thumbnail to view the larger file</li>
            <li>Once you click to view a larger file, you can use the keyboard to navigate between the other files</li>
            
        </ul>
    </div>

    

    <input id="fileupload" type="file" name="files[]" multiple="">

    <div id="progress" class="progress" style="margin-top:10px;">
        <div class="progress-bar progress-bar-primary"></div>
    </div>

    <div id="gallery"></div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="assets/jquery.ui.widget.js"></script>
    <script src="assets/jquery.iframe-transport.js"></script>
    <script src="assets/jquery.fileupload.js"></script>
    <script src="assets/jquery.colorbox.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->

    <script type="text/javascript">
        $(document).ready(function(){
            list_files();
        });
      'use strict';
      // Change this to the location of your server-side upload handler:
      var url = 'src/index.php';
      $('#fileupload').fileupload({
          url: url,
          dataType: 'json',
          previewThumbnail : false,
          start: function(e, data){
            console.log('Uploads started');
            //$('#progress .progress-bar').css('width', '0%');
          },
          success: function (e, data) {
              /*$.each(data.result.files, function (index, file) {
                  $('<p/>').text(file.name).appendTo('#files');
              });
              */
              list_files();
                  
          },
          progressall: function (e, data) {
              var progress = parseInt(data.loaded / data.total * 100, 10);
              $('#progress .progress-bar').css(
                  'width',
                  progress + '%'
              );
          }
      }).prop('disabled', !$.support.fileInput)
          .parent().addClass($.support.fileInput ? undefined : 'disabled');
        

    function list_files(){
        $.getJSON('?action=getFiles', {}, function(ret) { 
            $('#gallery').html(ret.html); 
            $(".group1").colorbox({rel:'group1'});
        })
    }

    function Delete(image_id){
        if (confirm("Are you sure ?")) {
            $.getJSON('?action=deleteFile', {image_id: image_id}, function(ret) {
                $('#placeholder_'+image_id).remove();
            });
        }
    }

    </script>

  </body>
</html>
<?PHP
function getData($image_id){
    $sql = "select * from images where image_id = :image_id";
    $stmt = DB::prepare($sql);
    $stmt->bindValue(':image_id', $image_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row){
        return $row;
    } else {
        return false;
    }
}
