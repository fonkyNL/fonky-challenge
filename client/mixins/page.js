export default {
  async asyncData({ $content }) {
    const pages = await $content('pages')
      .only(['title', 'slug'])
      .sortBy('slug')
      .fetch()
    return { pages }
  },

  computed: {
    currentPage() {
      return this.pages.find((page) => page.slug === this.$options.name) ?? null
    }
  },

  head() {
    if (! this.currentPage) {
      return
    }
      
    const { title } = this.currentPage
    
    return {
      title: `Fonky - ${title}`
    }
  }
}