@extends('layouts.shop')    

@section('title')
Library
@endsection

@section('content')
<div data-init="json">
    <json-example/>
    
</div>
<a href="https://example.com/" class="seamless">Click me!</a>

<script>
for (const link of document.querySelectorAll('a.seamless')) {
  const portal = document.createElement('portal');
  portal.src = link.href;
  portal.hidden = true;
  portal.style = 'position: fixed; top: 0; left: 0; width: 10vw; height: 10vh;';
  document.body.append(portal);

  link.onclick = async e => {
    if (portal.state === 'empty') {
      // The content couldn't be portaled, likely because it didn't opt-in.
      // Let the normal link click go through.
      return;
    }

    e.preventDefault();

    // Show the portal, and animate it to the whole viewport over 300 milliseconds.
    if (!matchMedia('(prefers-reduced-motion: reduce)').matches) {
      portal.hidden = false;
      await portal.animate([{ width: '100vw', height: '100vh' }], { duration: 300 }).finished;
    }

    // Once the preview is now displayed as the whole viewport, activate.
    // This performs the instant navigation/URL bar update/etc.
    try {
      await portal.activate();
    } catch {
      // If activation failed, restore the portal to hidden (so that back-navigations
      // don't show the full-viewport portal), and fall back to a normal navigation.
      portal.hidden = true;
      portal.style.width = '10vw';
      portal.style.height = '10vh';
      location.href = link.href;
    }
  };
}
</script>
@endsection
