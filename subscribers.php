<?php ob_start();
/*
Plugin Name: Email subscriber
Plugin URI: http://twitter.com/walid_naceri
Description: Best and the simple way to make your blog perfect and add a widget so people can subscribe to your email list. Free plugin with free support.
Version: 1.0
Author: Walid Naceri
Author URI:http://coder-dz.com
*/

add_action('widgets_init','init_widgets');

function init_widgets()
{
register_widget('walid');
}


class walid extends wp_widget
{
function walid()
{
$widget_ops = array('classname'=>'walid','description'=>'Subscribe form');
$control_ops = array('width'=>300,'height'=>250,'id_base'=>'imen');
$this->wp_widget('imen','Subscribe Form',$widget_ops,$control_ops);
}// close function construct walid

function widget($args,$instance)
{
extract($args);
$title = $instance['title'];

echo $before_widget;
echo $before_title.$title.$after_title;
wp_enqueue_script('walid',plugins_url('includes/widget.js',__FILE__),array('jquery'));
?>
<form action="" method="POST">
<input type="text" name="email" class="email" size="28" style="background-color: gray;">
<br/><br/>
<input type="submit" value="subscribe" name="subscribe" class="subscribe">
</form>
<?php

echo $after_widget;

}//close function widget

function form($instance)
{
$default = array('title'=>'Subscribe To News Letter');
$instance = wp_parse_args((array) $instance, $default);
?>
Title of the Form : <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title');?>" value="<?php echo $instance['title'];?>">


<?php
}//close function form

function update($new_instance,$old_instance)
{
$instance = $old_instance;
$instance['title'] = $new_instance['title'];
return $instance;

}//close function update
}// close class widget






$email = mysql_real_escape_string(htmlspecialchars(trim($_POST['email'])));
$email = str_replace(' ','',$email);
$ip    = $_SERVER['REMOTE_ADDR'];

if($email){
$dublicated = $wpdb->get_var("SELECT count(*) FROM subscription where email='$email'");
if($dublicated=='1'){
echo "<script>alert('This Email Exists in our Database!!')</script>";
echo '<meta http-equiv="refresh" content="0; URL=index.php">';
die();
}
else if(preg_match("/'|html|script|<|>|''|or'|'or| ''|=|''='/",$email)){
echo "<script>alert('Character You Have Entered Are Forbidden Security By Walid.')</script>";
echo '<meta http-equiv="refresh" content="0; URL=index.php">';
die();
}
else if(filter_var($email, FILTER_VALIDATE_EMAIL))
{
$wpdb->show_errors();
$insert = $wpdb->get_results("INSERT INTO subscription(email,ip) values('$email','$ip')");
echo "<script>alert('Your Email Has Been Add Successfully.')</script>";
echo '<meta http-equiv="refresh" content="0; URL=index.php">';
}
else{
echo "<script>alert('Please Make Sure Your Have Entered a Correct Email.')</script>";
echo '<meta http-equiv="refresh" content="0; URL=index.php">';
die();
}
}








add_action('admin_menu','admin_menu_init');

function admin_menu_init()
{
add_menu_page('subscription Manager','Subscribe','manage_options','admin.php?page=subscribers','imen_houbi');
}

function imen_houbi(){
global $wpdb;
$wpdb->show_errors();

$Create = $wpdb->get_results("CREATE TABLE IF NOT EXISTS subscription(id int(50) primary key auto_increment not null,
			      email varchar(50) not null,
			      ip varchar(50) not null)");









$get_rows = $wpdb->get_var("SELECT COUNT(*) FROM subscription");
$per_page = 10;
$page = ceil($get_rows/$per_page);

if(!isset($_GET['pages'])){
Header("Location: admin.php?page=admin.php?page=subscribers&pages=1");
}else{
$pages = $_GET['pages'];
}
$start = (($pages-1)*$per_page);






$get_subscribers = $wpdb->get_var("SELECT COUNT(*) FROM subscription");
$get_informations = $wpdb->get_results("SELECT * FROM subscription limit $start,$per_page");
$i=1;
?>
<TABLE BORDER="1" class="widefat" align="center"> 
<center><h3>You have <font color="red"><?echo $get_subscribers;?> </font>Subscriber</h3></center> 
<thead>
<tr>
<th>Number</th>
<th>Email</th>
<th>IP Address</th>
<th>Delete</th>
</tr>
</thead>
<?php foreach($get_informations as $informations){?>
<form action="" method="POST">
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $informations->email; ?></td>
<td><?php echo $informations->ip; ?></td>
<td><input type="submit" name="<?php echo $informations->id; ?>" value="Delete" class="button-primary"></a></td>
<tr>



<?php 
$i++;
if($_POST[$informations->id]){
$id =  $informations->id;
$delete = $wpdb->get_results("DELETE FROM subscription where id='$id'");
echo '<META http-equiv="refresh" content="0; URL=">';

}// if statment

}// for each loop
echo "</table>";

$next = $pages+1;
$prev = $pages-1;
echo "<center>";
echo "<br/><br/>";

if($prev>0){
echo'<a href="admin.php?page=admin.php?page=subscribers&pages='.$prev.'"><input type="button" class="button-primary" value="Prev"></a> ';
}

if($next<=ceil($get_rows/$per_page)){
echo' <a href="admin.php?page=admin.php?page=subscribers&pages='.$next.'"><input type="button" class="button-primary" value="Next"></a>'; 
}










}// the main function




































add_action('admin_menu','support_init');

function support_init()
{
add_submenu_page('admin.php?page=subscribers','Support','Support','manage_options','support','support');
}

function support(){

echo"
<br/><br/><h3>Thank you for downloading my plugin :)<h3><br/><br/>

<b><font color=red>* How to use it?</font></b><br/>
<b>Go to widget Activate the widget (Subscribe Form) and you can change the title.</b><br/>
<b>The form will appear on the index of your webpage.</b><br/><br/>
<b><font color=red>* How i can give you my opinion? and do you support your plugin for free?</font></b><br/>
<b>Well yes i give you a free support.</b><br/>
<b>if you have any question or any opinion how i can develop this application you can contact me through emails only walid.naceri@yahoo.com</b><br/>
<b>Also you can follow me on twitter @walid_naceri For free scripts and plugins.</b><br/><br/>

<b><font color=red>* How i can help you?</font></b><br/>
<b>You can Donate on my paypal the email is walid.naceri@yahoo.com</b><br/>
<b>All copyright reserved to walid.</b><br/><br/>


";

}
















?>

