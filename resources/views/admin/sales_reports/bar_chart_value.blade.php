<div class="row">
    <div class="chart">
        <h5>PRODUCT DEMAND ({{$year}})</h5>
        <h6>{{$chart_filter}}</h6>
        <canvas id="lineChart"></canvas>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>


<script>
    $(function () {
        let ctx = document.getElementById('lineChart');
        let salesChart = new Chart(ctx, {
            type: 'bar',
            fill: true,
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Beverages',
                        data: @json($montly_sold[0]),
                        borderColor: "gold",
                        borderWidth: 3
                    },
                    {
                        label: 'Canned Foods',
                        data: @json($montly_sold[1]),
                        borderColor: "pink",
                        borderWidth: 3
                    },
                    {
                        label: 'Condiments',
                        data: @json($montly_sold[2]),
                        borderColor: "rgba(153, 102, 255, 0.2)",
                        borderWidth: 3
                    },
                    {
                        label: 'Food Area',
                        data: @json($montly_sold[3]),
                        borderColor: "blue",
                        borderWidth: 3
                    },
                    {
                        label: 'Others',
                        data: @json($montly_sold[4]),
                        borderColor: "#111",
                        borderWidth: 3
                    },
                    {
                        label: 'Personal Care',
                        data: @json($montly_sold[5]),
                        borderColor: "green",
                        borderWidth: 3
                    },
                    {
                        label: 'Soap Area',
                        data: @json($montly_sold[6]),
                        borderColor: "red",
                        borderWidth: 3
                    },
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        console.log(@json($montly_sold));

        ctx.addEventListener('click', function(evt) {
            var firstPoint = salesChart.getElementAtEvent(evt)[0];
            if (firstPoint) {
                var label = salesChart.data.labels[firstPoint._index];
                var value = salesChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
                var legend =  salesChart.data.datasets[firstPoint._datasetIndex].label;

                var currentTime = new Date()
                var year = currentTime.getFullYear()

                if((@json($year) > year ) ){
                    $('#formModal').modal('show');
                    $('.modal-title').text('View Chart');
                    $.ajax({
                        url :"/admin/forcast/2024/edit",
                        dataType:"json",
                        data:{'month':label, 'category':legend},
                        beforeSend:function(){
                        },
                        success:function(data){

                            var list_2024 = "";
                            $.each(data.forcasting, function(key,value){

                                list_2024 += `
                                            <tr class=`+value.class+`>
                                                <td>`+value.category+`</td>
                                                <td>`+value.year+`</td>
                                                <td>`+value.month+`</td>
                                                <td>`+value.demand+`</td>
                                            </tr>
                                    `;
                            })
                            list_2024 += `
                                            <tr class="table-dark">
                                                <td><b>Top Products</b></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                    `;
                            $.each(data.tp2024, function(key,value){
                                var id = key + 1;
                                list_2024 += `
                                            <tr class="table-secondary">
                                                <td><b>`+id+`</b></td>
                                                <td></td>
                                                <td></td>
                                                <td><span class="bg-success badge">`+value.description+`</span></td>
                                            </tr>
                                    `;
                            })


                            $('#list_2024').empty().append(list_2024);
                            $('#regression').attr('src',data.regression);

                            console.log(data.tp2024);


                        }
                    })
                }else{
                    window.open("/admin/salesforcast/"+legend+"/"+label+'/'+@json($year));
                }
            }
        });


    });
</script>
