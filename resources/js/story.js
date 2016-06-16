const Platform = window.Platform

Platform.extend('app', 'storycms', {
  data() {
    return {
      content: null,
      sluggable: true,
      title: '',
      slug: ''
    }
  },

  ready() {
    this.sluggable = ! this.$get('content.id') > 0
    this.title = this.$get('content.title')
    this.slug = this.slugify(this.$get('content.slug') || '', '-')
  },

  methods: {
    slugify(string, separator = '-') {
      if (string == '') {
        return string
      }

      return string.toLowerCase()
        .replace(/^(_post_\/|_page_\/)/g, '')
        .replace(/[^\w\.]+/g, separator)
        .replace(/\s+/g, separator)
    },

    updateFromTitle() {
      if (this.slug == '' || this.sluggable == true) {
        this.slug = this.slugify(this.title, '-')
      }
    },

    updateFromSlug() {
      if (this.slug == '') {
        this.slug = this.slugify(this.title, '-')
      } else {
        this.slug = this.slugify(this.slug, '-')
      }

      this.sluggable = false
    }
  }
})

require('./bootstrap')
