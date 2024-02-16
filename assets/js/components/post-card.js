export default class PostCard {
  state = {
    estimatedReadingTime: '',
    title: '',
    taxonomies: [],
    excerpt: '',
    permalink: '',
    thumbnail: {
      url: '',
      alt: ''
    }
  }

  constructor(data) {
    if (!data) return

    this.state.title = data.title.rendered
    this.state.excerpt = data.excerpt.rendered
    this.state.permalink = data.link
    this.state.thumbnail.url = data._embedded['wp:featuredmedia'][0]?.source_url
    this.state.thumbnail.alt = data._embedded['wp:featuredmedia'][0]?.alt_text
    this.state.estimatedReadingTime = data.acf.estimate_reading_duration

    const taxonomies = {}

    data._embedded['wp:term'].forEach(taxonomy => {
      taxonomy.forEach(term => {
        const tax = term.taxonomy

        if (!(tax in taxonomies)) {
          taxonomies[tax] = []
        }

        taxonomies[tax].push({
          id: term.id,
          name: term.name
        })
      })
    })

    this.state.taxonomies = taxonomies
  }

  getTemplate() {
    let terms = ''

    this.state.taxonomies.category?.forEach(term => {
      terms += `<div class="f-post-card__category c-tag" data-term-id="${term.id}">${term.name}</div>`
    })

    this.state.taxonomies.post_tag?.forEach(term => {
      terms += `<div class="f-post-card__tag c-tag" data-term-id="${term.id}">${term.name}</div>`
    })

    return `<a class="f-post-card" href="${this.state.permalink}" target="_blank">
                    <div class="f-post-card__header">
                        <img class="f-post-card__thumbnail" src="${this.state.thumbnail.url}" alt="${this.state.thumbnail.alt}">
                    </div>
                    <div class="f-post-card__content">
                        <div class="f-post-card__read-duration"><span>${this.state.estimatedReadingTime}</span> Lecture</div>
                        <div class="f-post-card__terms">${terms}</div>
                        <div class="f-post-card__title">${this.state.title}</div>
                        <div class="f-post-card__excerpt">${this.state.excerpt}</div>
                    </div>
                </a>`
  }
}
