<style type="text/css">
.currency {
  padding-left:12px;
}

.currency-symbol {
  position:absolute;
  padding: 2px 5px;
}
</style>
<?php
//include('app-header.php');
include '../admin/dbcon.php';

if(isset($_POST['bt-save']))
{
	$service = $_POST['service'];
    $category = $_POST['category'];
    $fee = $_POST['fee'];
    

        $stm = $DB_con->prepare('INSERT INTO services (service, category, fee)
            VALUES(:service, :category, :fee)');
          $stm->bindParam(':service',$service);
          $stm->bindParam(':category',$category);
          $stm->bindParam(':fee',$fee);
          if($stm->execute()){
            header("location:service.php?service_inserted");
          }
           
        
 } 

if(isset($_POST['bt_edit']))
{
    $se_id = $_GET['se_id']; 
    $service = $_POST['service'];
    $category = $_POST['category'];
    $fee = $_POST['fee'];

     $stamt = $DB_con->prepare("UPDATE services SET 
        service = '".$service."',
        category = '".$category."',
        fee = '".$fee."'
        WHERE id=:id");
        $stamt->bindparam(":id",$se_id);
        
        if($stamt->execute()){
            
            header("Location:service.php?Service_Changed");

        }
}
if(isset($_POST['bt-c']))
{
    header("Location: service.php");
}
?>


	 <form method='post'>
    
    <table class='table'>
         <?php
        if(isset($_GET['se_id'])){
        $se_id = $_GET['se_id'];
        $query = $DB_con->prepare("SELECT * FROM services where id = '".$se_id."'");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $row=$query->fetch();

        echo"<label>Change date</label>";
} else {
        echo"<label>SET DENTAL SERVICES OFFERED</label>";
}
?>  
        <label></label>
    
        <tr>

            <td><input type="text" class="form-control" name="service" placeholder="Name of service offered" value="<?php if(isset($_GET['se_id'])){ echo $row['service']; } ?>" required></input></td>
            <td><input type="text" class="form-control" name="category" placeholder="Type of Service" value="<?php if(isset($_GET['se_id'])){ echo $row['category']; } ?>" required></input></td>
            <td><input type="number" class="form-control currency" name="fee" placeholder="Set Fee Schedule" value="<?php if(isset($_GET['se_id'])){ echo $row['fee']; } ?>" required></input></td>
         
             <?php if(isset($_GET['se_id']))
{
    ?>
            <td colspan="2">
            <button type="submit" class="btn btn-submit" name="bt_edit">
            <i class="glyphicon glyphicon-ok"></i>
            </button>
              
             <button class="btn btn-submit" name="bt-c">
            <i class="glyphicon glyphicon-remove"></i>
            </button>
            </td>
<?php
        } else {
 ?>
            <td colspan="2">
            <button type="submit" class="btn btn-submit" name="bt-save">
            <span class="glyphicon glyphicon-plus"></span> Save
            </button>  
            
            </td>
<?php
        }
        
?>  
            
            
        </tr>
 
    </table>
   
</form>

<script type="text/javascript">
(function($) {
  $.fn.currencyInput = function() {
    this.each(function() {
      var wrapper = $("<div class='currency-input' />");
      $(this).wrap(wrapper);
      //$(this).before("<span class='currency-symbol'>PHP</span>");
      $(this).change(function() {
        var min = parseFloat($(this).attr("min"));
        var max = parseFloat($(this).attr("max"));
        var value = this.valueAsNumber;
        if(value < min)
          value = min;
        else if(value > max)
          value = max;
        $(this).val(value.toFixed(2)); 
      });
    });
  };
})(jQuery);

$(document).ready(function() {
  $('input.currency').currencyInput();
});
</script>