<?php
/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]de Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

## Register Paths
rex_xform::addPath('xform', 'value', rex_path::addon('xform', 'lib/value/'));
rex_xform::addPath('xform', 'validate', rex_path::addon('xform', 'lib/validate/'));
rex_xform::addPath('xform', 'action', rex_path::addon('xform', 'lib/action/'));

if (rex::isBackend() && rex::getUser()) {
  rex_extension::register('PAGE_HEADER', 'rex_xform::getBackendCSS'); // rex_xform::css
}
