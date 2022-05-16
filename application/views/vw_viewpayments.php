<div class="container"><br><br>
    <div class="alertservice"></div>
    <form id="sel" method="post">
        <h4>Select Month and Year</h4>
        <input type="month" id="date" class="form-control" onchange="fun()">
    </form>
    <hr width="100%">
    <h4>Records</h4>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Voucher ID</th>
                <th scope="col">Description</th>
                <th scope="col">Category</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody id="fet">
            
        </tbody>
    </table>
</div>
</div>
<script>
    $( document ).ready(function() {
        const monthControl = document.querySelector('input[type="month"]');
        const date= new Date()
        const month=("0" + (date.getMonth() + 1)).slice(-2)
        const year=date.getFullYear()
        monthControl.value = `${year}-${month}`;
        fun();
    });

    function fun() {
        document.getElementById("fet").innerHTML = "";
        var value = $("#date").val();
        const myArray = value.split("-");
        var apiurl = "<?php echo base_url('home/getpaymentdata/'); ?>" + myArray[0] + '/' + myArray[1]
        fetch(apiurl, {
                method: 'GET',
                mode: 'no-cors',
                cache: 'no-cache'
            })
            .then(response => {
                if (response.status == 200) {
                    return response.json();
                } else {
                    console.log('Backend Error..!');
                    console.log(response.text());
                }
            })
            .then(data => {
                if (data.length > 0) {
                    
                    data.forEach(function(item) {
                        var htmlText = `
                            <tr class="align-middle">
                                <th scope="row">${item.id}</th>
                                <td>${item.description}</td>
                                <td>${item.category}</td>
                                <td>${item.amount}</td>
                                <td>${item.date}</td>
                                <td><a href="<?php echo base_url('home/editpayment/');?>${item.rid}" type="button" class="btn btn-primary form-control">Edit</button></td>
                                <td><button onclick="deleterecord(${item.rid})" type="button" class="btn btn-danger form-control">Delete</button></td>
                            </tr>
                        `;
                        
                        $("#fet").append(htmlText);
                    });
                } else {
                    $("#fet").append("<br><br><div class='alert alert-danger'>No data available</div>");
                }
            })
            .catch(() => {
                console.log("Network connection error");
            });
    }
    function deleterecord(rid){
        var urltext="<?php echo base_url('home/deleterecord/'); ?>"+rid;
        if(confirm('Are you sure you want to delete this record ?')){
            location.href=urltext;
        }
    }
</script>