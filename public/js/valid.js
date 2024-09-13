
$(document).ready(function() {
    $('.valied_number').on('input', function() {
    match = (/(\d{0,100})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
    this.value = match[1] + match[2];
  });
});
