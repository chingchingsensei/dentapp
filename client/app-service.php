<?php
include 'app-header.php'; 
include_once '../admin/dbcon.php';


      $sthandler = $DB_con->prepare("SELECT * FROM patient WHERE username = :username");
        $sthandler->bindParam(':username', $_SESSION['username']);
        $sthandler->execute();
        $trow=$sthandler->fetch();

        $pid = $trow['id'];


include 'app-nav.php';

  
        $sql = "SELECT DISTINCT category FROM services";
        $str = $DB_con->prepare($sql);
        $str->execute();
        
?>


	<div class="clearfix"></div>
  <div class="container">

    <div class="panel panel-default">
      <div class="panel-body">
      <div class="row-fluid">
    <table class="table table-responsive" style='display:inline-block'>
      <td><h4>SEARCH:</h4></td>
      <td><input type="text" name="search" id="search" class="form-control" placeholder="Please search here"></td>
      <td>
            <select name="category" class="form-control" id='filterText' style='display:inline-block' onchange='filterText()'>
              <option selected></option>
               <?php while ($rw = $str->fetch(PDO::FETCH_ASSOC)) { 
                 echo "<option value='" . $rw['category'] . "'>" . $rw['category'] . "</option>";
        } ?>
              </select>
      </td>
  </table>
  </div>
    <table class='table table-bordered table-responsive'  id='myTable'>


     <tr class="myHead">
      <th>Dental Service</th>
     <th>Category</th>
     <th>Fee Schedule</th>
     
     </tr>
     
    <?php 
        $limit = 7;

        $sq = $DB_con->prepare("SELECT * FROM services");
        $sq->setFetchMode(PDO::FETCH_ASSOC);
        $sq->execute();
        $total_result = $sq->rowCount();
        $total_page = ceil($total_result/$limit);

        if (!isset($_GET['page'])) {
            $page = 1;
        } else{
            $page = $_GET['page'];
        }

        $starting_limit = ($page-1)*$limit;

        $sw  = "SELECT * FROM services ORDER BY category DESC LIMIT $starting_limit, $limit";
        $r = $DB_con->prepare($sw);
        $r->execute();

            while($row = $r->fetch(PDO::FETCH_ASSOC))
                 {
                    echo "<tr class='content'><td>".$row['service']."</td>";;
                    echo "<td>".$row['category']."</td>";
                    echo "<td>".$row['fee']."</td>";
                    echo "</tr>";
                  }
                    ?>

               
    <tr>
        <td colspan="4" align="center">
            
                    <?php
                    for ($page=1; $page <= $total_page ; $page++):?>

                    <a href='<?php echo "?page=$page"; ?>' class="btn btn-green"><?php  echo $page; ?>
                     </a>

                    <?php endfor; ?>
        </td>
    </tr>
 
    </table>
    </div>
  </div>
</div>


<script src="bootstrap/js/bootstrap.min.js"></script>
<script>
function filterText()
  {  
    var rex = new RegExp($('#filterText').val());
    if(rex =="/all/"){clearFilter()}else{
      $('.content').hide();
      $('.content').filter(function() {
      return rex.test($(this).text());
      }).show();
  }
  }
  
function clearFilter()
  {
    $('.filterText').val('');
    $('.content').show();
  }

$('#search').on('keyup', function() {
  var value = $(this).val();
  var patt = new RegExp(value, "i");

  $('#myTable').find('tr').each(function() {
    if (!($(this).find('td').text().search(patt) >= 0)) {
      $(this).not('.myHead').hide();
    }
    if (($(this).find('td').text().search(patt) >= 0)) {
      $(this).show();
    }
  });
});


</script>
</body>
</html>