<?php

echo $this->Html->script(['/vendor/canvasjs.min']); ?>

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?=$company;?></h3>
                <p>Company</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <?php echo $this->Html->link('More info <i class="fa fa-arrow-circle-right"></i>','javascript:void(0);',array('class'=>'small-box-footer','escape' => false)); ?> 

        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?=$permit;?></h3>
                <p>Permit</p>
            </div>
            <div class="icon">
                <i class="ion ion-folder"></i>
            </div>
             <?php echo $this->Html->link('More info <i class="fa fa-arrow-circle-right"></i>',['controller'=>'forms','action'=>'index'],array('class'=>'small-box-footer','escape' => false)); ?> 

        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php echo $operations; ?></h3>

                <p>Operations</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
                <?php echo $this->Html->link('More info <i class="fa fa-arrow-circle-right"></i>',['controller'=>'operations','action'=>'index'],array('class'=>'small-box-footer','escape' => false)); ?> 

        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?php echo $category; ?></h3>

                <p>Agency</p>
            </div>
            <div class="icon">

                <i class="ion ion-pie-graph"></i>
            </div>
               <?php echo $this->Html->link('More info <i class="fa fa-arrow-circle-right"></i>',['controller'=>'categories','action'=>'index'],array('class'=>'small-box-footer','escape' => false)); ?> 
        </div>
    </div>
</div>
<div class="row">
    <section class="col-lg-12 connectedSortable">
        <div class="nav-tabs-custom">
            <div class="tab-content no-padding">
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            </div>
        </div>

    </section>
</div>
<!-- /.js for dashboard graph chart -->
<script>
    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Graph"
            },
            axisY: {
                title: "Forms",
                titleFontColor: "#4F81BC",
                lineColor: "#4F81BC",
                labelFontColor: "#4F81BC",
                tickColor: "#4F81BC"
            },
            axisY2: {
                title: "Transactionsy",
                titleFontColor: "#C0504E",
                lineColor: "#C0504E",
                labelFontColor: "#C0504E",
                tickColor: "#C0504E"
            },
            toolTip: {
                shared: true
            },
            legend: {
                cursor: "pointer",
                itemclick: toggleDataSeries
            },
            data: [{
                    type: "column",
                    name: "Forms",
                    legendText: "Forms",
                    showInLegend: true,
                    dataPoints: [
                        {label: "Forms", y: 266.21},
                    ]
                },
                {
                    type: "column",
                    name: "Transactionsy",
                    legendText: "Transactionsy",
                    axisYType: "secondary",
                    showInLegend: true,
                    dataPoints: [
                        {label: "Transactionsy", y: 10.46},
                    ]
                }]
        });
        chart.render();

        function toggleDataSeries(e) {
            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            chart.render();
        }

    }
</script>