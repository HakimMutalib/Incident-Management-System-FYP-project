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
                    <!-- nOTIFICATION -->
                    <div class="row" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">
                        <div class="col-lg-12">
                             <div class="card " style="background-color: rgb(23,29,40)">
                                <div class="card-header">Notifications</div>
                                    <div class="card-body">
                                        <div v-if="unreadnotifications.length > 0">
                                            <div v-for="(unread, index) in unreadnotifications" :key="index">
                                                <p class="alert alert-success" v-if="unread.type === 'App\\Notifications\\AdminTicketUpdate'">{{unread.data.name}} ({{unread.data.email}})  ticket ID of {{unread.data.id}} has been updated on {{unread.updated_at}}. <button type="button" class="btn-close btn-close-white" aria-label="Close"  @click="MaR"></button></p>
                                            </div>
                                        </div>

                                        <div v-if="unreadnotifications.length > 0">
                                            <div v-for="(unread, index) in unreadnotifications" :key="index">
                                                <p class="alert alert-success" v-if="unread.type === 'App\\Notifications\\AdminTicketMake'">{{unread.data.name}} ({{unread.data.email}})  ticket ID of {{unread.data.id}} has been updated on {{unread.updated_at}}. <button type="button" class="btn-close btn-close-white" aria-label="Close"  @click="MaR"></button></p>
                                            </div>
                                        </div>
                                    <a  v-show="unreadnotifications.length > 0" @click="markAsRead">Mark all as read!</a>
                                    <a  v-show="unreadnotifications.length == 0">No new notifications</a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END OF nOTIFICATION -->
                    <div class="row" v-else >
                        <div class="col-lg-12">
                             <div class="card " style="background-color: rgb(23,29,40)">
                                <div class="card-header">Notifications</div>
                                    <div class="card-body">
                                        <div v-if="unreadnotifications.length > 0">
                                            <div v-for="(unread, index) in unreadnotifications" :key="index">
                                                <p class="alert alert-success" v-if="unread.type === 'App\\Notifications\\TicketNotification'">Hi {{unread.data.name}} ({{unread.data.email}}), your ticket has been created on {{unread.created_at}} with a ticket ID of {{unread.data.id}}. <button type="button" class="btn-close btn-close-white" aria-label="Close"  @click="MaR"></button></p>
                                            </div>
                                        </div>

                                        <div v-if="unreadnotifications.length > 0">
                                            <div v-for="(unread, index) in unreadnotifications" :key="index">
                                                <p class="alert alert-success" v-if="unread.type === 'App\\Notifications\\UpdateTicket'">Hi {{unread.data.name}} ({{unread.data.email}}) ticket has been updated on {{unread.updated_at}} with a ticket ID of {{unread.data.id}}. <button type="button" class="btn-close btn-close-white" aria-label="Close"  @click="MaR"></button></p>
                                            </div>
                                        </div>
                                    <a  v-show="unreadnotifications.length > 0" @click="markAsRead">Mark all as read!</a>
                                    <a  v-show="unreadnotifications.length == 0">No new notifications</a>
                                    </div>
                                    </div>
                                </div>
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
        data(){
            return {
                unreadnotifications: {},

            }
        },
        mounted() {
            this.getNotifications();
            this.interval = setInterval(function() {
                this.getNotifications()
            }.bind(this), 500);
        },

        methods: {
            getNotifications(){
                axios.get('dashboard/unreadNotifications')
                .then((response) => {
                    console.log(response)
                    this.unreadnotifications = response.data

                }).catch((errors) => {
                    console.log(errors)
                });
            },
            markAsRead(){
                axios.get('dashboard/markAsRead').then((response) => {
                    location.reload()
                }).catch((errors) => {
                    console.log(errors)
                });
            },

            MaR(){
                axios.get('dashboard/MaR').then((response) => {

                }).catch((errors) => {
                    console.log(errors)
                });
            }
        },

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
