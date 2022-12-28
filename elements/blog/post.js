class BlogPost extends HTMLElement {
  connectedCallback() {
    console.log(this.attributes);
    this.innerHTML = `
      <form class="box">
        <fieldset>
          <legend><a href="post_view.php?id=${this.attributes.id.value}">${this.attributes.creator.value.split("_").join(" ")} - ${this.attributes.title.value.split("_").join(" ")}</a></legend>
          ${this.attributes.content.value.split("_").join(" ")}
        </fieldset>
      </form>
    `;
  }
}

customElements.define("blog-post", BlogPost);