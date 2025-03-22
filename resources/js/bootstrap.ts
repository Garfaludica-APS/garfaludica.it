/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
