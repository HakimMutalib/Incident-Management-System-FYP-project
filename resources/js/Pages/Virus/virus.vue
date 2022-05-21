<template>
    <div>
        <admin-layout>
            <div class="container-fluid">
                <h1>Virus Scanner</h1>
                <div class="text-center">
                    <i class="fas fa-desktop fa-10x"></i>
                </div>
                <br><br>
                <div class="text-center">
                    <p>Analyze suspicious files, domains, IPs and URLs to detect malware</p>
                </div>
                <br>
                <br>
                <div class="text-center">
                            <div v-if="results == 'clean site'">
                                <h3>{{message}}</h3>
                                <h1 class="glow">{{results}}</h1>
                            </div>

                            <div v-else>
                                <h3>{{message}}</h3>
                                <h1 class="dim">{{results}}</h1>
                            </div>
                        </div>
                        <br><br>
                <div class="container">
                    <div class="mx-auto" style="width: 100;">
                        <div class="input-group rounded">
                        <input type="search" class="form-control rounded" placeholder="Enter the website here" v-model="searchword" />
                        <button type="button" class="btn btn-primary" >
                            <i class="fas fa-search" @click="GetData"></i>
                        </button>
                        </div>
                        <br><br>


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
            results:'',
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
                                this.results = response.scans.CyRadar.result
                                this.message = response.verbose_msg
                                })
            .catch(err => console.error(err));

        },

    },


}



</script>

<style>
.glow {
  font-size: 50px;
  color: #fff;
  text-align: center;
  animation: glow 1s ease-in-out infinite alternate;
}

@-webkit-keyframes glow {
  from {
    text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #008000, 0 0 40px #008000, 0 0 50px #008000, 0 0 60px #008000, 0 0 70px #008000;
  }

  to {
    text-shadow: 0 0 20px #fff, 0 0 30px #00FF00, 0 0 40px #00FF00, 0 0 50px #00FF00, 0 0 60px #00FF00, 0 0 70px #00FF00, 0 0 80px #00FF00;
  }
}

.dim {
  font-size: 50px;
  color: #fff;
  text-align: center;
  animation: glow 1s ease-in-out infinite alternate;
}

@-webkit-keyframes dim {
  from {
    text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #FF0000, 0 0 40px #FF0000, 0 0 50px #FF0000, 0 0 60px #FF0000, 0 0 70px #FF0000;
  }

  to {
    text-shadow: 0 0 20px #fff, 0 0 30px #FF2400, 0 0 40px #FF2400, 0 0 50px #FF2400, 0 0 60px #FF2400, 0 0 70px #FF2400, 0 0 80px #FF2400;
  }
}

</style>
