<template>
    <div>
        <admin-layout>
        <div class="container-fluid">
          <div class="d-flex justify-content-center">
            <h1>File Malware Scanner</h1>
          </div><br>
          <div class="card-deck">
          <div class="card">
            <div class="text-center">
                            <div >
                                <img src="/assets/img/undraw_coding_re_iv62.svg"  width="304" height="236">
                            </div>
                        </div>
            <br><br>
            <div class="container">
              <div class="text-center">
                  <p>Analyze suspicious files, domains, IPs and URLs to detect malware</p>
              </div>
                <p v-if="scanid == ''"></p>
                <p v-else class="text-center">Your file has been submitted. Please click on the Check Results button to see the results</p>
                <br>
                <div class="mx-auto" style="width: 100;">
                    <label class="form-label" for="customFile"></label>
                    <input type="file" class="form-control" id="customFile" />
                    <button type="button" class="btn btn-primary" @click="GetData" >Submit</button>
                    <button type="button" class="btn btn-secondary" @click="GetReport">Check Results</button>
                </div>
            </div><br><br>
            <div class="card-footer">
            <div class="container">
                <div class="text-center">
                            <br><br>

                            <table class="table table-bordered table-dark">
                            <thead>
                                <tr>
                                <th scope="col">Anti Virus</th>
                                <th scope="col">Results</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">Avast</th>
                                <td>
                                  <div v-if="results1 === false">Clean File</div>
                                  <div v-else-if="results1 === true">Dangerous File</div>
                                </td>
                                </tr>

                                <tr>
                                <th scope="row">Avira</th>
                                <td>
                                  <div v-if="results2 === false">Clean File</div>
                                  <div v-else-if="results2 === true">Dangerous File</div>
                                </td>
                                </tr>

                                <tr>
                                <th scope="row">BitDefender</th>
                                <td>
                                  <div v-if="results3 === false">Clean File</div>
                                  <div v-else-if="results3 === true">Dangerous File</div>
                                </td>
                                </tr>

                                <tr>
                                <th scope="row">Cyren</th>
                                <td>
                                  <div v-if="results4 === false">Clean File</div>
                                  <div v-else-if="results4 === true">Dangerous File</div>
                                </td>
                                </tr>

                                <tr>
                                <th scope="row">Microsoft</th>
                                <td>
                                  <div v-if="results5 === false">Clean File</div>
                                  <div v-else-if="results5 === true">Dangerous File</div>
                                </td>
                                </tr>
                            </tbody>
                            </table>

                        </div>
            </div>
            <br>
            <br>
            </div>
              </div>
            </div>
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
    apikey: '44c81fef71511d9637e29314bb6c61e758710069b703e0cff3a432e01fb108cc',
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
      apiKey: '44c81fef71511d9637e29314bb6c61e758710069b703e0cff3a432e01fb108cc',
       results1:'',
       results2:'',
       results3:'',
       results4:'',
       results5:'',
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
                                this.results1 = response.scans.Avast.detected
                                this.results2 = response.scans.Avira.detected
                                this.results3 = response.scans.BitDefender.detected
                                this.results4 = response.scans.Cyren.detected
                                this.results5 = response.scans.Microsoft.detected
                                this.message = response.verbose_msg
                                })
            .catch(err => console.error(err));

        },


  },

  computed:{

    newValue(){

  }
 }
}
</script>
