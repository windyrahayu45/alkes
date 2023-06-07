$('input[type=text]').bind('input', function() {
      var c = this.selectionStart,
          r = /[^a-zA-Z0-9 .]/gi,
          v = $(this).val();
      if(r.test(v)) {
        $(this).val(v.replace(r, ''));
        c--;
      }
      this.setSelectionRange(c, c);
});

$('textarea').bind('input', function() {
      var c = this.selectionStart,
          r = /[^a-zA-Z0-9 .?]/gi,
          v = $(this).val();
      if(r.test(v)) {
        $(this).val(v.replace(r, ''));
        c--;
      }
      this.setSelectionRange(c, c);
});