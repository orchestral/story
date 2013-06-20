<?php

Event::listen('orchestra.form: extension.orchestra/story', 'Orchestra\Story\Services\Events\ExtensionHandler@onFormView');
