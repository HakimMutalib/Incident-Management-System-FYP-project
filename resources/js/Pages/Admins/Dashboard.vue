<template>
<admin-layout>

  <template #header>
    <h1 class="m-0">Dashboard</h1>
  </template>
  <section>
  <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="page-title-box">
                        <div class="row align-items-center">
                            <div class="col-sm-6">

                            </div>

                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end page-title -->
                    <div class="row">
                        <div class="col-sm-6 col-xl-6">
                            <div class="card">
                                <div class="info-box ">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                                        <div class="card-heading p-4">
                                            <div class="mini-stat-icon float-right">
                                                <i class="mdi mdi-cube-outline bg-primary  text-white"></i>
                                            </div>
                                            <div>
                                                <h5 class="font-16">New Users Past 30 Days</h5>
                                            </div>
                                            <h3 class="mt-4 text-success" >{{users}}</h3>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-6">
                            <div class="card">
                                <div class="info-box ">
                                    <span class="info-box-icon bg-danger "><i class="fas fa-ticket-alt"></i></span>
                                        <div class="card-heading p-4">
                                            <div class="mini-stat-icon float-right">
                                                <i class="mdi mdi-briefcase-check bg-success text-white"></i>
                                            </div>
                                            <div>
                                                <h5 class="font-16">Active Tickets</h5>
                                            </div>
                                            <h3 class="mt-4 text-success">{{ticket}}</h3>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card m-b-30">
                                <div class="card-body">
                               <apexchart :width="chart2.width" :height="chart2.height" :type="chart2.type" :options="chart2.options" :series="chart2.series"></apexchart>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-xl-6">
                            <div class="card m-b-30">
                                <div class="card-body">
                                <apexchart :width="chart.width" :height="chart.height" :type="chart.type" :options="chart.options" :series="chart.series"></apexchart>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                         <div class="col-xl-6">
                            <div class="card m-b-30">
                                <div class="card-body">
                                <apexchart :width="chart3.width" :height="chart3.height" :type="chart3.type" :options="chart3.options" :series="chart3.series"></apexchart>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->



                </div>
                <!-- container-fluid -->
            </div>

        </div>
    </section>
</admin-layout>




</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import VueApexCharts from "vue3-apexcharts";
      export default {
        props:
         {
            chart: Object,
            chart2: Object,
            chart3: Object,
            users: Number,
            ticket: Number
        },
        components:{
        AdminLayout,

     },


    }





</script>
