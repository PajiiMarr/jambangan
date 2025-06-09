import Chart from 'chart.js/auto';
import * as FilePond from 'filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';

import './calendar-swiper.js';

window.Chart = Chart;
window.FilePond = FilePond;
window.FilePondPluginImagePreview = FilePondPluginImagePreview;

FilePond.registerPlugin(FilePondPluginImagePreview);
