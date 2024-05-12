import './bootstrap';
import { createApp } from 'vue';
import * as VueGoogleMaps from 'vue3-google-map';
import Map from './components/Map.vue';

const app = createApp({})

app.component('MapTest', Map)


app.mount('#app')
