<main class='py-5'>
    <section class='dashboard py-5'>
        <?php
        foreach ($optionsList as $option) {
        ?>
            <div class='option-card border border-dark'>
                <a href='#'>
                    <?php echo $option['optName'] ?>
                </a>
            </div>
        <?php } ?>
    </section>
</main>