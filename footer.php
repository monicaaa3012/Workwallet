<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
    <script>
    function change_cat(){
       var category_id=document.getElementById('category_id').value;
       window.location.href='';
    }

    function delete_confir(id,page){
        var check=confirm("Are you sure");
		if(check==true){
			window.location.href=page+"?type=delete&id="+id;
		}
    }

    function set_to_date(){
		var from_date=document.getElementById('from_date').value;
		document.getElementById('to_date').setAttribute("min",from_date);
	}
</script>
</body>

</html>