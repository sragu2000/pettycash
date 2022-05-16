<div class="container">
    <br><br>
    <h3 style="text-align: center;" class="text-secondary">Login</h3>
    <form id="signin" method="post">
        <input type="text" value="admin" id="username" required class="form-control" placeholder="Username"><p></p>
        <input type="password" value="admin123" id="password" required class="form-control" placeholder="Password"><p></p>
        <button type="submit" class="btn btn-success form-control">Login</button><p></p>
        <button type="Reset" class="btn btn-warning form-control">Clear</button>
    </form>
</div>
<script>
    $(document).on("submit","#signin",(e)=>{
        e.preventDefault();
        var toServer=new FormData();
        toServer.append('username',$("#username").val());
        toServer.append('password',$("#password").val());
        fetch("<?php echo base_url('authenticate/signinuser'); ?>",{
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
            alert(data.message); window.location.reload();
        })
        .catch(() => {
            console.log("Network connection error");
            alert("Reloading"); window.location.reload();
        });
    });
</script>