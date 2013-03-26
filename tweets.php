<!DOCTYPE html>
<html>
  <body>
    <script src="http://widgets.twimg.com/j/2/widget.js"></script>
    <script>
new TWTR.Widget({
version: 2,
type: 'profile',
rpp: 2,
interval: 30000,
width: '370',
height: '100',
theme: {
shell: {
background: '#F3BD01',
color: '#000000'
},
tweets: {
background: '#000000',
color: '#FFFFFF', 
links: '#F3BD01'
}
},
features: {
scrollbar: false,
loop: false,
live: false,
hashtags: true,
timestamp: true,
avatars: false,
behavior: 'all'
}
}).render().setUser('ChillersHockey').start();
    </script>
  </body>
</html>