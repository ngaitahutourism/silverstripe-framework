<?php

namespace SilverStripe\Control;

use SilverStripe\ORM\DataModel;
use SilverStripe\Core\ClassInfo;

/**
 * Triggers a call to flush() on all implementors of Flushable.
 */
class FlushRequestFilter implements RequestFilter {

	/**
	 * @inheritdoc
	 *
	 * @param SS_HTTPRequest $request
	 * @param Session $session
	 * @param DataModel $model
	 *
	 * @return bool
	 */
	public function preRequest(SS_HTTPRequest $request, Session $session, DataModel $model) {
		if(array_key_exists('flush', $request->getVars())) {
			foreach(ClassInfo::implementorsOf('SilverStripe\\Core\\Flushable') as $class) {
				$class::flush();
			}
		}

		return true;
	}

	/**
	 * @inheritdoc
	 *
	 * @param SS_HTTPRequest $request
	 * @param SS_HTTPResponse $response
	 * @param DataModel $model
	 *
	 * @return bool
	 */
	public function postRequest(SS_HTTPRequest $request, SS_HTTPResponse $response, DataModel $model) {
		return true;
	}

}