<template>
    <div>
        <admin-layout>
          <section class="content">
            <div class="container-fluid">
                <div class="searchbar">
      <form @submit.prevent="fetchSearchNews">
        <input type="text" placeholder="search..." v-model="searchword">
      </form>
      <div class="search-icons">
        <li v-if="!isBusy" class="fas fa-search" @click="fetchSearchNews"></li>
        <li v-else class="fas fa-spinner fa-spin"></li>
        <li class="fas fa-times" @click="fetchTopNews"></li>
      </div>
    </div>
    <div class="result-list">
      <article v-for="(article, index) in articles" :key="index" @click="navTo(article.url)">
        <header>
          <img v-if="article.urlToImage" :src="article.urlToImage" alt="">
          <li v-else class="fas fa-image"></li>
        </header>
        <section v-html="article.title"></section>
        <footer>
          <li class="fas fa-chevron-right"></li>
        </footer>
      </article>
    </div>
    <div ref="infinitescrolltrigger" id="scroll-trigger">
      <li v-if="showloader" class="fas fa-spinner fa-spin"></li>
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
        maxPerPage: 20,
        searchword: '',
        articles: [],
        country: 'us'
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
        this.apiUrl = 'https://newsapi.org/v2/top-headlines?country=' + this.country +
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
        observer.observe(this.$refs.infinitescrolltrigger);
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
