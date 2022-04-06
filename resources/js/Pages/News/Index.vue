<template>
    <div>
        <admin-layout>
          <section class="content">
                <div class="container-fluid">
                  <h1>Cyber News</h1>
                    <div class="searchbar">
                      <form @submit.prevent="fetchSearchNews">
                        <div class="input-group">
                          <div class="form-outline">
                            <input type="search" id="form1" placeholder = "Search.." class="form-control" v-model="searchword"/>
                          </div>
                          <button type="button" class="btn btn-primary">
                            <i v-if="!isBusy" class="fas fa-search" @click="fetchSearchNews"></i>
                          </button>
                        </div>
                        </form>
                    </div>
                    <ul></ul>

                  <div class="row">
                      <article v-for="(article, index) in articles" :key="index"  class="col-lg-4 mb-3 d-flex align-items-stretch" >
                              <div class="card-deck ">
                                  <div class="card">
                                        <img class="card-img-top" v-if="article.urlToImage" :src="article.urlToImage" style="width: 100%; height: 15vw; object-fit: cover;" alt="200x200">
                                        <li v-else class="fas fa-image"></li>
                                        <div class="card-body">
                                          <h2 v-html="article.title" @click="navTo(article.url)" style= cursor:pointer class="underline-on-hover" ></h2>
                                            <small class="text-muted">
                                              <h6 v-html="article.author"></h6>
                                            </small>
                                          <p v-html="article.description"></p>
                                        </div>
                                        <div class="card-footer">
                                            <p>Published at: </p>
                                            <p v-html="article.publishedAt"></p>
                                        </div>
                                  </div>
                              </div>
                      </article>
                    </div>

                </div>
          </section>
        </admin-layout>
    </div>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout'

export default {
   components: {
            AdminLayout,
        },
  data()  {
      return {
        apiKey: '1db75d4466ab4d698992b8c5c3a22588',
        apiUrl: '',
        isBusy: false,
        showloader: false,
        currentPage: 1,
        totalResults: 0,
        maxPerPage: 9,
        searchword: '',
        articles: [],
        country: 'my'
      }
    },
    computed: {
      pageCount() {
        return Math.ceil(this.totalResults/this.maxPerPage);
      }
    },
    methods: {
      navTo(url) {
        window.open(url);
      },
      resetData() {
        this.currentPage = 1;
        this.articles = [];
      },
      fetchSearchNews() {
        if(this.searchword !== '')
        {
          this.apiUrl = 'https://newsapi.org/v2/everything?q=' + this.searchword +
                        '&pageSize=' + this.maxPerPage +
                        '&apiKey=' + this.apiKey;
          this.isBusy = true;
          this.resetData();
          this.fetchData();
        }
        else {
          this.fetchTopNews();
        }
      },
      fetchTopNews() {
        this.apiUrl = 'https://newsapi.org/v2/everything?q=cybersecurity'  +
                        '&pageSize=' + this.maxPerPage +
                        '&apiKey=' + this.apiKey;
        this.isBusy = true;
        this.searchword = '';

        this.resetData();
        this.fetchData();
      },
      fetchData() {
        let req  = new Request(this.apiUrl + '&page=' + this.currentPage);
        fetch(req)
          .then((resp) => resp.json())
          .then((data) => {
            this.totalResults = data.totalResults;
            data.articles.forEach(element => {
              this.articles.push(element);
            });
            this.isBusy = false;
            this.showloader = false;
          })
          .catch((error) => {
            console.log(error);
          })
      },
      scrollTrigger() {
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if(entry.intersectionRatio > 0 && this.currentPage < this.pageCount) {
              this.showloader = true;
              this.currentPage += 1;
              this.fetchData();
            }
          })
        })
       
      }
    },
    created() {
      this.fetchTopNews();
    },
    mounted() {
      this.scrollTrigger();
    }
}
</script>

<style lang="scss" scoped>

.underline-on-hover:hover {

    text-decoration: underline;

}

</style>