@extends('pages.page_stley')

@section('title')
{{ config('app.name') }}
@endsection
@section('page-sidebar')
@include('pages.page_sidemenu')
@endsection
@section('content-wrapper')
<!-- START PAGE CONTENT-->
<?php
 $months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
 ?>
<div class="content-wrapper">
   <div class="page-content fade-in-up">
       <div class="row">
         <div class="col-md-auto col-md-12">
           <div class="ibox ibox-primary">
               <div class="ibox-head">
                   <div class="ibox-title ">สรุปผลการตรวจประเมิน 5ส   Year : {{ $Year}} - {{ $months[$Month]}} <span class="badge badge-success">Self  Audit</span> </div>
                   <!-- <div>
                       <a class="btn btn-info btn-sm" href="javascript:;">New Task</a>
                   </div> -->
               </div>
               <div class="ibox-body">
                 <div>
                     <canvas id="bar_Selt" style="height:400px;"></canvas>
                 </div>

               </div>
           </div>
         </div>

         <div class="col-md-auto col-md-12">
           <div class="ibox ibox-primary">
               <div class="ibox-head">
                   <div class="ibox-title">สรุปผลการตรวจประเมิน 5ส   Year : {{ $Year}} - {{ $months[$Month]}} <span class="badge badge-success">Committee  Audit</span></div>
                   <!-- <div>
                       <a class="btn btn-info btn-sm" href="javascript:;">New Task</a>
                   </div> -->
               </div>
               <div class="ibox-body">

                 <div>
                     <canvas id="bar_Committee" style="height:400px;"></canvas>
                 </div>


               </div>
           </div>
         </div>

         <div class="col-md-auto col-md-12">
           <div class="ibox ibox-primary">
               <div class="ibox-head">
                   <div class="ibox-title">สรุปผลการตรวจประเมิน 5ส   Year : {{ $Year}} - {{ $months[$Month]}}  <span class="badge badge-success">Top  Audit</span></div>
                   <!-- <div>
                       <a class="btn btn-info btn-sm" href="javascript:;">New Task</a>
                   </div> -->
               </div>
               <div class="ibox-body">


                 <div>
                     <canvas id="bar_Top" style="height:400px;"></canvas>
                 </div>
               </div>
           </div>
         </div>
       </div>
   </div>
</div>
<!-- END PAGE CONTENT-->

@endsection

@section('jsfooter')
 <script src="/assets/vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>

 <script type="text/javascript">
 $(function() {
   const Area ={!! $Area !!};
   const AreaResult ={!! $SeltResult !!};
   const CommitResult = {!! $CommitResult !!};
   const TopResult =  {!! $TopResult !!};

   var backgroundColor = ['#03989e','#160042','#db7093','#3cb371','#7722aa','#6d4059','#b76b95','#ff8d47','#a14242','#35e7bf','#6f4d3b','#0000bd','#66887c','#b2c3bd']
   var borderColor =  ['rgba(0,0,0,0)','rgba(0,0,0,0)','rgba(0,0,0,0)','rgba(0,0,0,0)','rgba(0,0,0,0)','rgba(0,0,0,0)','rgba(0,0,0,0)','rgba(0,0,0,0)','rgba(0,0,0,0)','rgba(0,0,0,0)','rgba(0,0,0,0)','rgba(0,0,0,0)','rgba(0,0,0,0)','rgba(0,0,0,0)']

  let merged_Area=borderColor.map((border,i)=>{
      return {
            "border": borderColor[i]
            ,"background": backgroundColor[i]
            ,"datapoin": AreaResult[i]
            ,"labels": Area[i]
    };
  })

const Area_dataSort =merged_Area.sort(function(b,a){
    return a.datapoin-b.datapoin;
});

  const Area_bc=[];
  const Area_bgc=[];
  const Area_score=[];
  const Area_lbl=[];
  for(i=0;i <Area_dataSort.length;i++){
    Area_bc.push(Area_dataSort[i].border);
    Area_bgc.push(Area_dataSort[i].background);
    Area_score.push(Area_dataSort[i].datapoin);
    Area_lbl.push(Area_dataSort[i].labels);

  }

  let merged_CommitResult=borderColor.map((border,i)=>{
      return {
            "border": borderColor[i]
            ,"background": backgroundColor[i]
            ,"datapoin": CommitResult[i]
            ,"labels": Area[i]
    };
  })

const Commit_dataSort =merged_CommitResult.sort(function(b,a){
    return a.datapoin-b.datapoin;
});

const Commit_bc=[];
  const Commit_bgc=[];
  const Commit_score=[];
  const Commit_lbl=[];
  for(i=0;i <Commit_dataSort.length;i++){
    Commit_bc.push(Commit_dataSort[i].border);
    Commit_bgc.push(Commit_dataSort[i].background);
    Commit_score.push(Commit_dataSort[i].datapoin);
    Commit_lbl.push(Commit_dataSort[i].labels);

  }

 //TOP
  let merged_TopResult=borderColor.map((border,i)=>{
      return {
            "border": borderColor[i]
            ,"background": backgroundColor[i]
            ,"datapoin": TopResult[i]
            ,"labels": Area[i]
    };
  })

  const Top_dataSort =merged_TopResult.sort(function(b,a){
    return a.datapoin-b.datapoin;
});

 const Top_bc=[];
  const Top_bgc=[];
  const Top_score=[];
  const Top_lbl=[];
  for(i=0;i <Top_dataSort.length;i++){
    Top_bc.push(Top_dataSort[i].border);
    Top_bgc.push(Top_dataSort[i].background);
    Top_score.push(Top_dataSort[i].datapoin);
    Top_lbl.push(Top_dataSort[i].labels);

  }




   var ctx = document.getElementById('bar_Selt').getContext('2d');
   new Chart(ctx, {
        type: 'bar',
        data: {
          labels: Area_lbl,
          datasets: [{
            data:  Area_score,
            backgroundColor: Area_bgc,
            borderColor: Area_bc ,
            borderWidth: 1
          }]
        },
        options: {
            layout: {
              padding: {
                left: 0,
                right: 0,
                top: 15,
                bottom: 0
              }
            },
            events: [],
            responsive: true,
            maintainAspectRatio: false,
            legend: {
              display: false
            },
            scales: {
              xAxes: [{
                        ticks: {
                            autoSkip: false,
                            maxRotation: 60,
                            minRotation: 60
                        }
                    }],
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  display: true
                }
              }]
            },
            animation: {
              duration: 1,
              onComplete: function() {
                var chartInstance = this.chart,
                  ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    if (dataset.data[index] > 0) {
                      var data = dataset.data[index];
                      ctx.fillText(data, bar._model.x, bar._model.y);
                    }
                  });
                });
              }
            }
        }
      });


      var ctx = document.getElementById('bar_Committee').getContext('2d');
      var   backgroundColor = ['#03989e','#160042','#db7093','#3cb371','#7722aa','#6d4059','#b76b95','#ff8d47','#a14242','#35e7bf','#6f4d3b','#0000bd','#66887c','#b2c3bd'];
      var borderColor =  ['rgba(0,0,0,0)' ];
      new Chart(ctx, {
           type: 'bar',
           data: {
             labels: Commit_lbl,
             datasets: [{
               data:  Commit_score,
               backgroundColor: Commit_bgc,
               borderColor: Commit_bc ,
               borderWidth: 1
             }]
           },
           options: {
               layout: {
                 padding: {
                   left: 0,
                   right: 0,
                   top: 15,
                   bottom: 0
                 }
               },
               events: [],
               responsive: true,
               maintainAspectRatio: false,
               legend: {
                 display: false
               },
               scales: {
                 xAxes: [{
                           ticks: {
                               autoSkip: false,
                               maxRotation: 60,
                               minRotation: 60
                           }
                       }],
                 yAxes: [{
                   ticks: {
                     beginAtZero: true,
                     display: true
                   }
                 }]
               },
               animation: {
                 duration: 1,
                 onComplete: function() {
                   var chartInstance = this.chart,
                     ctx = chartInstance.ctx;

                   ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                   ctx.textAlign = 'center';
                   ctx.textBaseline = 'bottom';

                   this.data.datasets.forEach(function(dataset, i) {
                     var meta = chartInstance.controller.getDatasetMeta(i);
                     meta.data.forEach(function(bar, index) {
                       if (dataset.data[index] > 0) {
                         var data = dataset.data[index];
                         ctx.fillText(data, bar._model.x, bar._model.y);
                       }
                     });
                   });
                 }
               }
           }
         });



         var ctx = document.getElementById('bar_Top').getContext('2d');
         var   backgroundColor = ['#03989e','#160042','#db7093','#3cb371','#7722aa','#6d4059','#b76b95','#ff8d47','#a14242','#35e7bf','#6f4d3b','#0000bd','#66887c','#b2c3bd'];
         var borderColor =  ['rgba(0,0,0,0)' ];
         new Chart(ctx, {
              type: 'bar',
              data: {
                labels: Top_lbl,
                datasets: [{
                  data:  Top_score,
                  backgroundColor: Top_bgc,
                  borderColor: Top_bc ,
                  borderWidth: 1
                }]
              },
              options: {
                  layout: {
                    padding: {
                      left: 0,
                      right: 0,
                      top: 15,
                      bottom: 0
                    }
                  },
                  events: [],
                  responsive: true,
                  maintainAspectRatio: false,
                  legend: {
                    display: false
                  },
                  scales: {
                    xAxes: [{
                              ticks: {
                                  autoSkip: false,
                                  maxRotation: 60,
                                  minRotation: 60
                              }
                          }],
                    yAxes: [{
                      ticks: {
                        beginAtZero: true,
                        display: true
                      }
                    }]
                  },
                  animation: {
                    duration: 1,
                    onComplete: function() {
                      var chartInstance = this.chart,
                        ctx = chartInstance.ctx;

                      ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                      ctx.textAlign = 'center';
                      ctx.textBaseline = 'bottom';

                      this.data.datasets.forEach(function(dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        meta.data.forEach(function(bar, index) {
                          if (dataset.data[index] > 0) {
                            var data = dataset.data[index];
                            ctx.fillText(data, bar._model.x, bar._model.y);
                          }
                        });
                      });
                    }
                  }
              }
            });

  });
 </script>
@endsection
