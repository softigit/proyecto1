<li class="product">
<a href="cotizacion.php?id=<?php echo $product->id ?>">
<img src="assets/img/<?php echo $product->id ?>.png" alt="<?php echo $product->name ?>" />
<?php echo $product->name ?> <i><?php echo $product->manufacturer?></i> <b>$<?php echo number_format($product->price, 0, '', '.');  ?></b>
</a>
</li>