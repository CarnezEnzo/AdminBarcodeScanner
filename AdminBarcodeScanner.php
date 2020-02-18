<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace AdminBarcodeScanner;

use Thelia\Module\BaseModule;
use AdminBarcodeScanner\Model\ProductEanQuery;
use Thelia\Model\ProductSaleElementsQuery;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;

class AdminBarcodeScanner extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'adminbarcodescanner';

    /** @var string */
    const MAIN_TABLE = 'adminbarcodescanner_main_table';

    /** @var array */
    const POSSIBLE_CONFIGURATIONS = array(
      'default',
      'custom'
    );

    public function postActivation(ConnectionInterface $con = null)
    {
      try {
          ProductEanQuery::create()->findOne();
      } catch (\Exception $e) {
          $database = new Database($con);
          $database->insertSql(null, [__DIR__ . "/Config/thelia.sql"]);
      }

      if (null === self::getConfigValue(self::MAIN_TABLE))
          self::setConfigValue(self::MAIN_TABLE, 'default');
    }
}
