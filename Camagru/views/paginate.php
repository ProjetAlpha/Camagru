<div class="columns is-mobile is-centered">
    <nav class="pagination is-small is-centered" role="navigation" aria-label="pagination" style="height:100%;">
        <ul class="pagination-list">
            <?php if (isset($pagination) && $pagination > 0): ?>
                <?php for ($i = 1; $i <= $pagination; $i++): ?>
                    <?php if (isset($current) && $current == $i): ?>
                        <li class="is-small-mobile"><a class="pagination-link is-current" aria-label="Goto page <?php echo htmlspecialchars($i); ?>"
                            href="/page/<?php echo htmlspecialchars($i); ?>" aria-current="page"><?php echo htmlspecialchars($i); ?></a></li>
                        <?php else: ?>
                            <li class="is-small-mobile"><a class="pagination-link" aria-label="Goto page <?php echo htmlspecialchars($i); ?>" href="/page/<?php echo htmlspecialchars($i); ?>">
                                <?php echo htmlspecialchars($i); ?></a></li>
                            <?php endif; ?>
                        <?php endfor; ?>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
