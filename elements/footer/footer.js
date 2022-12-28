class Footer extends HTMLElement {
  connectedCallback() {
    this.innerHTML = `
    <footer class="flex-row flex-justify-centre">
      <p class="small">Copyright ${new Date().getFullYear()}</p>
    </footer>
  `;
  }
}

customElements.define("footer-custom", Footer);