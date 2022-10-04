<template>
    <div>
        <admin-layout>
          <section class="content">
                <div class="container-fluid">
                    <h1>Cyber News</h1>
                    <div class="searchbar" v-if="$page.props.auth.hasRole.superAdmin || $page.props.auth.hasRole.admin">
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
                                        <img class="card-img-top" v-if="article.media" :src="article.media" style="width: 100%; height: 15vw; object-fit: cover;" alt="200x200">
                                        <li v-else class="fas fa-image"></li>
                                        <div class="card-body">
                                          <h2 class="underline-on-hover" v-html="article.title" @click="navTo(article.link)" ></h2>
                                          <p class="sum" v-html="article.summary" maxlength="50"></p>
                                        </div>
                                        <div class="card-footer">
                                            <p>Published at: {{format_date(article.published_date)}}</p>
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
import moment from 'moment'

export default {
   components: {
            AdminLayout,

        },
  data()  {
      return {
        apiKey: '-bkCU62yL6Tsuqki0EVNBGzyEgYBmh-xguz83uGD43o',
        apiUrl: '',
        isBusy: false,
        showloader: false,
        currentPage: 1,
        totalResults: 0,
        maxPerPage: 9,
        searchword: '',
        articles: [],
        country: 'my',

      }

    },

    mounted() {
    if (localStorage.searchword) {
      this.searchword = localStorage.searchword;
    }
    },

    watch: {
    searchword(newSearchword) {
      localStorage.searchword = newSearchword;
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

      format_date(value){
                if (value) {
                return moment(String(value)).format('DD/MM/YYYY')
                }
            },

      fetchSearchNews() {
        if(this.searchword !== '')
        {
          this.apiUrl = 'https://newsapi.org/v2/everything?q=' + this.searchword +
                        '&pageSize=' + this.maxPerPage;
          this.isBusy = true;
          this.resetData();
          this.fetchData();
        }
        else {
          this.fetchTopNews();
        }
      },
      fetchTopNews() {
        this.apiUrl = 'https://newscatcher.p.rapidapi.com/v1/search_enterprise?q=' + 'Cyber' + '+Security' +
                        '&page_size=' + this.maxPerPage + '&media=True' + '&sources=thehackernews.com';
        this.isBusy = true;
        this.resetData();
        this.fetchData();
      },
      fetchData() {
        let options = {
          headers: {
            'X-RapidAPI-Key': '47c1a99852msh858760df8f28ea0p1c727cjsncc706f13718e',
          }
        };
        let req  = new Request(this.apiUrl + '&page=' + this.currentPage, options);
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

    },
    created() {
      this.fetchTopNews();
    },

}
</script>

<style lang="scss" scoped>
.underline-on-hover:hover {
    text-decoration: underline;
}
.sum {
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
}

</style>
