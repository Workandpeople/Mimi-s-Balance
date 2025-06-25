// resources/js/app.js

import '../css/app.css';
import 'bootstrap';
import 'aos/dist/aos.css';

import initEcho        from './modules/echo';
import initAOS         from './modules/aos';
import monitorReverb   from './modules/reverbStatus';
import initFiltersAndChart from './modules/filtersAndChart';
import initUploadInvoice from './modules/uploadInvoice';

initEcho();      // initialise Echo
initAOS();       // initialise AOS
monitorReverb(); // monitoring sans réinitialiser Echo
initFiltersAndChart();
initUploadInvoice();