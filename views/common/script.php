<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script>
  window.addEventListener('DOMContentLoaded', function() {
    // ショートカットキー処理
    window.addEventListener('keydown', function(e) {
      switch (e.key) {
        case 'b':  // ページ最下部にスクロールする処理
          let doc = document.documentElement;
          let bottom = doc.scrollHeight - doc.clientHeight;
          window.scroll(0, bottom);
          break;
        case 't':  // ページ最上部にスクロールする処理
          window.scroll(0, 0);
          break;
      }
    });
  });
</script>
