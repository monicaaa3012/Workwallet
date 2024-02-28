<?php
 include 'header.php';
checkUser();
$msg="";
$category="";
$label="Add";
if(isset($_GET['id']) && $_GET['id'] > 0){
    $label="Edit";
    $id = get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from category where id=$id ");
    if(mysqli_num_rows($res)==0){
        redirect('category.php');
        die();
    }
    $row=mysqli_fetch_assoc($res);
    $category=$row['name'];
}

if (isset($_POST['submit'])) {
    $name = get_safe_value($_POST['name']);
    
     $type="add";
     $sub_sql="";
     if(isset($_GET['id']) && $_GET['id'] > 0){
        $type="edit";
        $sub_sql="and id!=$id";
     }
     
     $res = mysqli_query($con, "SELECT * FROM category WHERE name = '$name' $sub_sql");
     if (mysqli_num_rows($res) > 0) {
        $msg="category already exist";
     }else{
        $sql="insert into category(name) values('$name')";
   		if(isset($_GET['id']) && $_GET['id']>0){
   			$sql="update category set name='$name' where id=$id";
   		}
        mysqli_query($con, $sql);
        redirect('category.php');
     }
   
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/user_header.css">
</head>
<body>
    

<h2><?php  echo $label?>Category</h2>
<br>
<br>
<br>
<a href="category.php">Back</a>
<br>
<br>
<br>
<br>
<br>
<div class="wrapper">
<form method="post">
    
            <h1>Category</h1>
            <div class="input-box">
            <input type="text" name="name"  placeholder="category"required value="<?php echo $category?>">
            </div>
            <button type="submit" name="submit" class="btn">submit</button>
    </table>
</form>
</div>
<?php echo $msg;
?>
</body>
</html>
<?php
include'footer.php';
?>