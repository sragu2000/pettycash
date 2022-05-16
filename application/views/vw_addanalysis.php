<div class="container"><br><br>
    <form id="add" method="post">
        <input type="text" id="category" class="form-control" placeholder="Category Name"><p></p>
        <button type="submit" class="btn btn-primary form-control">Submit</button>
    </form>
</div>
<script>
    $(document).on("submit","#add",(e)=>{
        e.preventDefault();
        var toServer=new FormData();
        toServer.append('category',$("#category").val());
        fetch("<?php echo base_url('home/newcategory');?>",{
            method:'POST',
            body: toServer,
            mode: 'no-cors',
            cache: 'no-cache'})
        .then(response => {
            if (response.status == 200) {
                return response.json();            
            }
            else {
                alert('Backend Error..!');
                console.log(response.text());
            }
        })
        .then(data => {
            alert(data.message);
        })
        .catch(() => {
            console.log("Network connection error");
            alert("Reloading");
        });
    })
</script>