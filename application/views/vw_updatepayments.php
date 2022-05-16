<div class="container"><br><br>
    <form id="editamount" method="post">
        <input type="text" id="desc" class="form-control" placeholder="Description" required>
        <p></p>
        <input type="text" id="voucher" class="form-control" placeholder="Voucher Number" required>
        <p></p>
        <input type="number" class="form-control" id="amount" placeholder="Amount" required> 
        <p></p>
        <button type="submit" class="btn btn-success form-control">Update</button><p></p>
        <button type="reset" class="btn btn-warning form-control">Reset</button>
    </form>
</div>
<script>
    $(document).on("submit","#editamount",(e)=>{
        e.preventDefault();
        var toServer=new FormData();
        toServer.append('description',$("#desc").val());
        toServer.append('vouchernum',$("#voucher").val());
        toServer.append('amount',$("#amount").val());
        toServer.append('recid',<?php echo $record; ?>);

        fetch("<?php echo base_url('home/editpay');?>",{
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
            location.href="<?php echo base_url('home/viewPayments'); ?>"
        })
        .catch(() => {
            console.log("Network connection error");
            alert("Reloading");
        });
    })

    var getUrl=`<?php echo base_url("home/getparticularrecord/$record"); ?>`;
    fetch(getUrl,{method:'GET',mode: 'no-cors',cache: 'no-cache'})
    .then(response => {
        if (response.status == 200) {return response.json();}
        else {console.log('Backend Error..!');console.log(response.text());}
    })
    .then(data => {
        if (data.length>0) {
            data.forEach(function(item){
                $("#desc").val(item.description);
                $("#voucher").val(item.voucherid);
                $("#amount").val(item.amount);
            });
        }
    })
    .catch(() => {console.log("Network connection error");});
</script>