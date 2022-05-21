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
            <p v-if="scanid == ''"></p>
            <p v-else class="text-center">Your file has been submitted. Please click on the Check Results button to see the results</p>
            <p class="text-center">{{results}}</p>
            <br>
            <div class="container">
                <div class="mx-auto" style="width: 100;">
                    <label class="form-label" for="customFile"></label>
                    <input type="file" class="form-control" id="customFile" />
                    <button type="button" class="btn btn-primary" @click="GetData" >Submit</button>
                    <button type="button" class="btn btn-secondary" @click="GetReport">Check Results</button>
                </div>
            </div>
            <br>
            <br>
        </div>
        </admin-layout>
    </div>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout'
const options = {
  method: 'POST',
  headers: {Accept: 'text/plain', 'Content-Type': 'application/x-www-form-urlencoded'},
   body: new URLSearchParams({
    apikey: '108b339f8e77fa963840ec618c8699ed1d67733076001534166dd5739522c1d3',
    file: 'this.image'
   })
};
const options2 = {method: 'GET'};

export default {
    components: {
        AdminLayout,
    },

  data() {
    return {
      image: '',
      apiKey: '108b339f8e77fa963840ec618c8699ed1d67733076001534166dd5739522c1d3',
       results:'',
       scanid:'',
       message:'',
        errors:[]
    }
  },
  methods: {
    handleImage(e) {
      const selectedImage = e.target.files[0]; // get first file
      this.createBase64Image(selectedImage);
    },
    createBase64Image(fileObject) {
      const reader = new FileReader();
      reader.onload = (e) => {
        this.image = e.target.result;

      };
      reader.readAsDataURL(fileObject);
    },

    GetData(){
            fetch('https://www.virustotal.com/vtapi/v2/file/scan?' , options)
            .then(response => response.json())
            .then(response => {
                                console.log(response)
                                this.scanid = response.scan_id
                                this.message = response.verbose_msg
                                })
            .catch(err => console.error(err));

        },

    GetReport(){
            fetch('https://www.virustotal.com/vtapi/v2/file/report?apikey='+ this.apiKey +'&resource='+this.scanid+'&allinfo=false', options2)
            .then(response => response.json())
            .then(response => {
                                console.log(response)
                                this.results = response.scans.Avira.detected
                                this.message = response.verbose_msg
                                })
            .catch(err => console.error(err));

        },


  }
}
</script>
