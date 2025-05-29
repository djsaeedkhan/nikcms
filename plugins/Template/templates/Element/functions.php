<?php
function getAge($then) {
  $then_ts = strtotime($then);
  $then_year = date('Y', $then_ts);
  $age = date('Y') - $then_year;
  if(strtotime('+' . $age . ' years', $then_ts) > time()) $age--;
  return $age;
}
if($this->request->getQuery('ajax_map') and $this->request->getQuery('ajax_map') != ""){

  $cat = $this->Query->category("locations",['get_type'=>'first','slug' => $this->request->getQuery('ajax_map')]);
  $data = [];
  if(isset($cat['title'])){
    $results = $this->Query->post('associations',[
      'contain'=>['PostMetas','Categories'],
      'contain_where' => [
        'meta_key' => 'locations',
        'meta_value' => strtolower($cat['id']),
      ],'get_type'=>'all','order' => 'Posts.id']);

    global $result;
    foreach($results as $result):
      $data[] = [
        'id'=> $result['id'],
        'title' => $this->Query->the_title(),
        'the_image' => $this->Query->the_image(['size'=>'thumbnail']) !=""?Cake\Routing\Router::url($this->Query->the_image(['size'=>'thumbnail'])):'',
        'the_permalink' => $this->Query->the_permalink(),
      ];
    endforeach;
  }
  die($this->response->withType('application/json')->withStringBody(json_encode($data)));
}
?>