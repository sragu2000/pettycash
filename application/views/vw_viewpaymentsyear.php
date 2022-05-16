<div class="container"><br><br>
    <div class="alertservice"></div>
    <form id="sel" method="post">
        <h4>Select Year</h4>
        <select id="ddlYears" class="form-control" onchange="fun()"></select>
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
    window.onload = function () {
        //Reference the DropDownList.
        var ddlYears = document.getElementById("ddlYears");
 
        //Determine the Current Year.
        var currentYear = (new Date()).getFullYear();
 
        //Loop and add the Year values to DropDownList.
        for (var i = 1950; i <= currentYear; i++) {
            var option = document.createElement("OPTION");
            option.innerHTML = i;
            option.value = i;
            ddlYears.appendChild(option);
        }
        $("#ddlYears").val(2022);
        fun();
    };
    function fun() {
        document.getElementById("fet").innerHTML = "";
        var value = $("#ddlYears").val();
        var apiurl = "<?php echo base_url('home/getpaymentdatayear/'); ?>" + value
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