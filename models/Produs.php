<?php

namespace app\models;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Yii;

/**
 * This is the model class for table "produs_prd".
 *
 * @property int $id_prd
 * @property string $nume_prd
 * @property string $descriere_prd
 * @property int $tip_prd
 * @property string $pret_prd
 * @property int $stoc_prd
 * @property int $idanm_prd
 * @property string $imagine_prd
 */
class Produs extends \yii\db\ActiveRecord
{
    const NEW_WIDTH = 150;
    const NEW_HEIGHT = 150;
    const UPLOAD_FOLDER = '/opt/lampp/htdocs/petshop/web/uploads/';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produs_prd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nume_prd', 'tip_prd', 'pret_prd', 'stoc_prd', 'imagine_prd', 'idanm_prd'], 'required', 'on' => 'add'],
            [['nume_prd', 'tip_prd', 'pret_prd', 'stoc_prd', 'imagine_prd', 'idanm_prd'], 'required', 'on' => 'edit'],
            [['tip_prd', 'stoc_prd'], 'integer'],
            [['imagine_prd'], 'file', 'extensions' => 'jpg, png, jpeg, bmp'],
            [['pret_prd'], 'number'],
            [['nume_prd'], 'string', 'max' => 50],
            [['descriere_prd'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_prd' => 'ID Produs',
            'idanm_prd' => 'Animal',
            'nume_prd' => 'Nume',
            'descriere_prd' => 'Descriere',
            'tip_prd' => 'Tip',
            'pret_prd' => 'Preț',
            'stoc_prd' => 'Stoc',
            'imagine_prd' => 'Poză',
        ];
    }

    public static function resizeImage($path)
    {
        $image = new Imagine();
        $width = $image->open($path)->getSize()->getWidth();
        $height = $image->open($path)->getSize()->getHeight();
        $ratio = $width / $height;

        if ($height > 150 || $width > 150) {
            if ($ratio > 1) {
                $new_height = self::NEW_WIDTH / $ratio;
                $image->open($path)->resize(new Box(self::NEW_WIDTH, $new_height))->save($path);
            } elseif ($ratio == 1) {
                $image->open($path)->resize(new Box(self::NEW_HEIGHT, self::NEW_HEIGHT))->save($path);
            } else {
                $new_width = $ratio * self::NEW_HEIGHT;
                $image->open($path)->resize(new Box($new_width, self::NEW_HEIGHT))->save($path);
            }
        }
    }

    public static function saveFile($path, $extension)
    {
        $unique_name = uniqid('file_');
        $file = $unique_name . '.' . $extension;
        try {
            yii\helpers\BaseFileHelper::createDirectory($path . '/web/uploads/');
        } catch (yii\base\Exception $e) {
            die($e->getMessage());
        }

        return $file;
    }
}
