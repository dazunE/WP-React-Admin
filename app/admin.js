/* global window, document */
if (! window._babelPolyfill) {
  require('babel-polyfill');
}

import React from 'react';
import ReactDOM from 'react-dom';
import Admin from './containers/Admin.js';

document.addEventListener(
     'DOMContentLoaded', function() {
      ReactDOM.render(<Admin wpObject={window.wpr_object} />, document.getElementById('wp-info-admin'));
});
