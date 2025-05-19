<?php
namespace Shop;
use Admin\View\Helper\FuncHelper;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;

use Mpdfs\CreatePdf;
use Shop\View\Helper\ShopHelper;

class Export {
	//--------------------------------------------------------------------------------
	public function getpdf($token = null, $result){
		
        $pdf = new CreatePdf;
        $pdf->show([$result],[
            'filedest'=>'D',
            'orientation' =>'L',
            'filename'=>'factor_'.$token.'.pdf',
            'SetTitle' =>'صورتحساب  فروش کالا',
            'SetFooter'=>'صفحه {PAGENO}',
            'SetHeader'=>['text'=>'شماره فاکتور : '.$token ],
        ]);
		return 1;
	}
	//--------------------------------------------------------------------------------
	public function forms($results = null){
        $setting = $this->Func->OptionGet('plugin_shop');
        if($setting['plugin_shop'])
            $setting = unserialize($setting['plugin_shop']);
        $p = new FuncHelper(new \Cake\View\View());

        $address = isset($results['shop_addresses'][0])?$results['shop_addresses'][0]:null;
		$string = '<p>تاریخ صدور فاکتور: '.jdate('y/m/d h:i').'</p>
		<style>.text-center{text-align:center}tr td{text-align:center}</style>
		<h1 class="text-center" style="font-size:22px;">'.($setting['factor_title1'] != ''?$setting['factor_title1']:'عنوان اول').'</h1>
		<h2 class="text-center" style="font-size:18px;">'.($setting['factor_title2'] != ''?$setting['factor_title2']:'عنوان دوم').'</h2><br>

        <p><b>مشخصات فروشنده: </b>';
        $string .=$p->province_list($setting['store_province']).' - '. $setting['store_city'].' - ';
        $string .=$setting['store_address'] .' - '. $setting['store_zipcode']; 
        $string .='</p>
        <p><b>مشخصات خریدار: </b>'.
            ( $address != null?
                $address['first_name'] .' ' . $address['last_name']  .'.<br>'.
                $address['billing_city'] .' / '. $address['billing_address'].'<br>'.
                
            :'').'
        </p>
		
		<table class="" border="1" style="width:100%;">
            <thead>
            <tr>
                <th>#</th>
                <th>عنوان محصول</th>
                <th>قیمت</th>
                <th>تعداد</th>
                <th>مبلغ کل</th>
            </tr>
            </thead>
            <tbody>';
            $i=1;$total = 0;
        foreach ($results['shop_orderproducts'] as $item):
            $string .= 
            '<tr class="text-center">
                <td>'.$i++.'</td>
                <td style="text-align:right !important"><strong>'.$item['name'].'</strong>';
                    if(isset($item['shop_orderattributes']) and count($item['shop_orderattributes'])){
                        foreach($item['shop_orderattributes'] as $itm)
                            $string .= '<div class="small">'.
                                (isset($itm['shop_attribute']['title'])?$itm['shop_attribute']['title']:'-').' : '.
                                (isset($itm['shop_attributelist']['title'])?$itm['shop_attributelist']['title']:'-').'</div>';
                    }
                $string .='</td>
                <td>'.ShopHelper::PriceShow($item['price']).'</td>
                <td>'.$item['quantity'].'</td>
                <td>'.ShopHelper::PriceShow($item['subtotal']).'</td>
            </tr>';
            $total+=$item['subtotal'];
        endforeach;

        $string .='<tr class="text-center">
            <td></td>
            <td>هزینه ارسال</td>
            <td>'.ShopHelper::PriceShow(15000).'</td>
            <td></td>
            <td>'.ShopHelper::PriceShow(15000).'</td>
        </tr>';

        $string .='<tr><td colspan="3" style="text-align:left">مبلغ تخفیف: 
                </td><td colspan="2">'.ShopHelper::PriceShow(0).'</td></tr>';

        $string .='<tr><td colspan="3" style="text-align:left">جمع کل فاکتور: 
                    </td><td colspan="2">'.ShopHelper::PriceShow($total + 15000).'</td></tr>';

        $string .='</tbody>
        </table>';
		return $string;
	}
}