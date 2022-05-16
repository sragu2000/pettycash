<div class="container"><br><br>
    <center><h3>PETTY CASH <i class="fa-solid fa-money-bills"></i></h3><center><br>
    <table class="table" style="text-align: center">
        <thead>
            <tr>
                <th scope="col" class="bg-secondary" >Total Petty Cash Amount</th>
                <th scope="col" class="bg-secondary" >Amount Available</th>
                <th scope="col" class="bg-secondary" >Amount Spent</th>
            </tr>
        </thead>
        <tbody id="fet">
            <tr class="align-middle">
                <th id="totalamount" class="bg-primary"></th>
                <th id="amountavailable" class="bg-success"></th>
                <th id="amountspent" class="bg-warning"></th>
            </tr>
        </tbody>
    </table>
    <form id="addamount" method="post">
        <input type="text" id="desc" class="form-control" placeholder="Description" required>
        <p></p>
        <input type="text" id="voucher" class="form-control" placeholder="Voucher Number" required>
        <p></p>
        <select class="form-control" id="analysis" required>
            <option disabled selected>Select Category</option>
        </select>
        <p></p>
        <input type="number" class="form-control" id="amount" placeholder="Amount" required> 
        <p></p>
        <button type="submit" class="btn btn-success form-control"><i class="fa-solid fa-plus"></i> &nbsp; Add</button><p></p>
        <button type="reset" class="btn btn-warning form-control"><i class="fa-solid fa-arrows-rotate"></i> &nbsp; Reset</button>
    </form>
</div>
<script>
    fetch("<?php echo base_url('home/getCategories'); ?>",{method:'GET',mode: 'no-cors',cache: 'no-cache'})
    .then(response => {
        if (response.status == 200) {return response.json();}
        else {console.log('Backend Error..!');console.log(response.text());}
    })
    .then(data => {
        if (data.length>0) {
            data.forEach(function(item){
                var htmltext=`<option id="${item.id}" value="${item.id}">${item.cname}</option>`;
                $("#analysis").append(htmltext);
            });
        }
    })
    .catch(() => {console.log("Network connection error");});

    const d=new Date();
    var month=d.getMonth()+1;
    var year=d.getFullYear();
    var requrl="<?php echo base_url('home/getCurentCashDetails/'); ?>"+year+"/"+month;
    fetch(requrl,{method:'GET',mode: 'no-cors',cache: 'no-cache'})
    .then(response => {
        if (response.status == 200) {return response.json();}
        else {console.log('Backend Error..!');console.log(response.text());}
    })
    .then(data => {
        if (data.length>0) {
            data.forEach(function(item){
                $("#totalamount").append(item.totalamount);
                var total=parseInt(item.totalamount);
                var spent=parseInt(item.spent);
                $("#amountavailable").append(total-spent);
                $("#amountspent").append(item.spent);
            });
        }
    })
    .catch(() => {console.log("Network connection error");});

    $(document).on("submit","#addamount",(e)=>{
        e.preventDefault();
        var toServer=new FormData();
        toServer.append('description',$("#desc").val());
        toServer.append('vouchernum',$("#voucher").val());
        toServer.append('analysis',$("#analysis").val());
        toServer.append('amount',$("#amount").val());
        toServer.append('date',new Date().toISOString().split('T')[0]);
        fetch("<?php echo base_url('home/addpayment'); ?>",{
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
    })
</script>