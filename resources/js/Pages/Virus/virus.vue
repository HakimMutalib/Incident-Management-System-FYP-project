<template>
    <div>
        <admin-layout>
            <div class="container-fluid">
                <div class="d-flex justify-content-center">
                    <h1>Website Malware Scanner</h1>
                </div><br>
                <div class="card-deck">
                    <div class="card">
                        <div class="text-center">
                            <div >
                                <img src="/assets/img/undraw_coding_re_iv62.svg"  width="304" height="236">
                            </div>
                        </div>
                <br><br>
                <div class="text-center">
                    <p>Analyze suspicious files, domains, IPs and URLs to detect malware</p>
                </div>
                <br>
                <br>
                <div class="container"> 
                    <div class="mx-auto" style="width: 100;">
                        <div class="input-group rounded">
                        <input type="search" class="form-control rounded" placeholder="Enter the website here" v-model="searchword" />
                        <button type="button" class="btn btn-primary" >
                            <i class="fas fa-search" @click="GetData"></i>
                        </button>
                        </div>
                    </div>
                </div> 
                        <br>
                        <div class="card-footer">
                <div class="container">
                    <div class="mx-auto" style="width: 100;">
                        <div class="text-center">
                            <br>
                               <h3>{{message}}</h3>
                               <br>

                            <table class="table table-bordered table-dark">
                            <thead>
                                <tr>
                                <th scope="col">Anti Virus</th>
                                <th scope="col">Results</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">AutoShun</th>
                                <td>{{results1}}</td>
                                </tr>

                                <tr>
                                <th scope="row">CRDF</th>
                                <td>{{results2}}</td>
                                </tr>

                                <tr>
                                <th scope="row">CyRadar</th>
                                <td>{{results3}}</td>
                                </tr>

                                <tr>
                                <th scope="row">Forcepoint ThreatSeeker</th>
                                <td>{{results4}}</td>
                                </tr>

                                <tr>
                                <th scope="row">Fortinet</th>
                                <td>{{results5}}</td>
                                </tr>
                            </tbody>
                            </table>

                        </div>
                    </div>

                </div>
                </div>
                </div>
                </div>
            </div>

        </admin-layout>
    </div>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout'

const options = {method: 'GET', headers: {Accept: 'application/json'}};

export default{
    components: {
        AdminLayout,
    },

data() {
        return{
            apiKey: '108b339f8e77fa963840ec618c8699ed1d67733076001534166dd5739522c1d3',
            apiUrl:'',
            searchword:'',
            allinfo : true,
            results1:'',
            results2:'',
            results3:'',
            results4:'',
            results5:'',
            message:'',
            errors:[]

        }
    },

    methods: {
        GetData(){
            fetch('https://www.virustotal.com/vtapi/v2/url/report?' + 'apikey=' + this.apiKey + '&resource=' + this.searchword + '&allinfo=false&scan=0', options)
            .then(response => response.json())
            .then(response => {
                                console.log(response)
                                this.results1 = response.scans.AutoShun.result
                                this.results2 = response.scans.CRDF.result
                                this.results3 = response.scans.CyRadar.result
                                this.results4 = response.scans["Forcepoint ThreatSeeker"].result
                                this.results5 = response.scans.Fortinet.result
                                this.message = response.verbose_msg
                                })
            .catch(err => console.error(err));

        },

    },


}



</script>
