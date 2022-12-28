class HeaderLink extends HTMLElement {
  connectedCallback() {
    let currentPage = window.location.pathname.split("/").pop().split(".")[0];
    let link = `${this.attributes.link.value === currentPage ? "#" : `${this.attributes.link.value}.php`}`;

    document.title = `${currentPage.charAt(0).toUpperCase()}${currentPage.slice(1).split("_").join(" ")}`;

    this.innerHTML = `
      <button class=${this.attributes.link.value === currentPage ? "italic" : "normal"} onclick="location.href='${link}'">
       ${this.attributes.text.value}
      </button>
      `
  }
}

customElements.define("header-link", HeaderLink);