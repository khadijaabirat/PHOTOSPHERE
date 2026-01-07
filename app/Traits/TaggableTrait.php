<?php

trait TaggableTrait {
    protected array $tags=[];
    protected function normalizeTag(string $tag):string{
        return strtolower(trim($tag));
    }
public function addTag(string $tag): void
{
    $tag = $this->normalizeTag($tag);
    if(!$this->hasTag($tag)){
        $this->tags[]=$tag;
    }
}


public function removeTag(string $tag): void{
  if($this->hasTag($tag)){
$this->tags=array_filter($this->tags,fn($t) => $t != $tag);
$this->tags =array_values($this->tags);
  }
 
}

public function getTags(): array{
 return $this->tags;
}

public function hasTag(string $tag): bool{
    $tag=$this->normalizeTag($tag);
 return in_array($tag,$this->tags,true);
}
public function hasAllTags(array $tags): bool{
foreach($tags as $tag){
    if(!$this->hasTag($tag)){
        return false;
    }
    } return true;

}
public function clearTags(): void{
$this->tags=[];
}

public function hasAnyTag(array $tags): bool{
foreach($tags as $tag){
    if($this->hasTag($tag)){
        return true;
    }
   }  return false;

}


}
?>