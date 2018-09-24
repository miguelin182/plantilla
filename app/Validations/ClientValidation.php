<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 18/09/2018
 * Time: 09:39 AM
 */

namespace App\Validations;

use Respect\Validation\Validator as v;
use App\Helpers\ResponseHelper;
class ClientValidation
{
    public static function validate (array $model) {
        try{
            $v = v::key('txtnombre', v::stringType()->notEmpty())
                ->key('txtap', v::stringType()->notEmpty())
                ->key('txtam', v::stringType()->notEmpty())
                ->key('txtrfc', v::stringType()->notEmpty())
                ->key('txttelefono', v::stringType()->notEmpty())
                ->key('txtcelular', v::stringType()->notEmpty());



            $v->assert($model);
        } catch (\Exception $e) {
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'txtnombre' => 'Campo  requerido',
                'txtap' => 'Campo  requerido',
                'txtam' => 'Campo  requerido',
                'txtrfc' => 'Campo  requerido',
                'txttelefono' => 'Campo  requerido',
                'txtcelular' => 'Campo  requerido',
            ]);

            exit(json_encode($rh));
        }
    }
}