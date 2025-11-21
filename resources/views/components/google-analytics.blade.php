@if(config('services.google_analytics.measurement_id'))
<!-- Google Analytics (GA4) -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.measurement_id') }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  
  gtag('config', '{{ config('services.google_analytics.measurement_id') }}', {
    'page_title': document.title,
    'page_path': window.location.pathname
  });
</script>
@endif