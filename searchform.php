<form class="l-search-modal__form" action="<?= esc_url(home_url('/')) ?>">
    <div class="l-search-modal__field">
        <input id="searchInput" name="s" type="search" placeholder="Rechercher" aria-label="Search"
               value="<?= get_search_query() ?>">
        <button type="submit">
            <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.85566 15.7814C12.5797 15.7814 15.5986 12.706 15.5986 8.91228C15.5986 5.11855 12.5797 2.04313 8.85566 2.04313C5.13165 2.04313 2.11275 5.11855 2.11275 8.91228C2.11275 12.706 5.13165 15.7814 8.85566 15.7814ZM8.85566 17.43C13.4734 17.43 17.2169 13.6165 17.2169 8.91228C17.2169 4.20806 13.4734 0.394531 8.85566 0.394531C4.23789 0.394531 0.494446 4.20806 0.494446 8.91228C0.494446 13.6165 4.23789 17.43 8.85566 17.43Z" fill="black"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.6778 14.3743C13.9938 14.0524 14.5062 14.0524 14.8221 14.3743L19.2741 18.9096C19.5901 19.2315 19.5901 19.7534 19.2741 20.0753C18.9581 20.3972 18.4458 20.3972 18.1298 20.0753L13.6778 15.54C13.3618 15.2181 13.3618 14.6962 13.6778 14.3743Z" fill="black"/>
            </svg>
        </button>
    </div>
</form>
