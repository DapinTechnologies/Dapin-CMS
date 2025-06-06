

<?php $__env->startSection('title', 'Digital Library'); ?>

<?php $__env->startSection('content'); ?>

<style>
/* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    color: #212529;
}

/* Section Header */
h2 {
    font-size: 2rem;
    font-weight: bold;
    color: #343a40;
}

/* Search Bar */
.search-bar {
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
}

.search-input {
    width: 100%;
    max-width: 500px;
    padding: 10px 15px;
    border: 1px solid #dee2e6;
    border-radius: 25px;
    font-size: 1rem;
    outline: none;
    transition: box-shadow 0.3s ease-in-out;
}

.search-input:focus {
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.25);
    border-color: #007bff;
}

/* Card Styling */
.card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    background-color: #ffffff;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.card-img-top {
    border-bottom: 1px solid #dee2e6;
}

.material-thumbnail {
    border-radius: 0;
    transition: transform 0.3s ease-in-out;
}

.material-thumbnail:hover {
    transform: scale(1.1);
}

/* Card Body */
.card-body {
    padding: 20px;
    text-align: center;
}

.card-title {
    font-size: 1.15rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.card-text {
    font-size: 0.9rem;
    color: #6c757d;
}

.card h2 {
    font-size: 1rem;
    font-weight: bold;
    margin: 10px 0;
    color: #007bff;
}

.card h5 {
    font-size: 0.95rem;
    margin-bottom: 5px;
    color: #495057;
}

/* Responsive Grid */
@media (max-width: 768px) {
    h2 {
        font-size: 1.5rem;
    }

    .card-title {
        font-size: 1rem;
    }

    .card-text {
        font-size: 0.85rem;
    }
}
</style>

<div class="container py-4">
    <h2 class="text-center mb-4">Digital Library</h2>

    <!-- Search Bar -->
    <form action="<?php echo e(route('library.index')); ?>" method="GET" class="search-bar">
        <input type="text" name="query" value="<?php echo e(request('query')); ?>" class="search-input" placeholder="Search by title, author, or publisher..." />
        <button type="submit" class="btn btn-primary"><?php echo e(__('Search')); ?></button>
   
    </form>

    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm">
                <a href="<?php echo e(route('viewshow', $material->id)); ?>">
                    <img src="<?php echo e(asset($material->thumbnail)); ?>" alt="<?php echo e($material->title); ?>" class="card-img-top material-thumbnail" style="height: 150px; object-fit: cover;">
                </a>
                <div class="card-body">
                    <h5 class="card-title">Title: <?php echo e($material->title); ?></h5>
                    <h5 class="card-title">Author: <?php echo e($material->author); ?></h5>
                    <h5 class="card-title">Publisher: <?php echo e($material->publisher); ?></h5>
                    <h2>Category: <?php echo e($material->category->name); ?></h2>
                    <p class="card-text">
                        Added on: <?php echo e(date('d F, Y', strtotime($material->created_at))); ?>

                    </p>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-center">No materials found for your search query.</p>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\student\digital\index.blade.php ENDPATH**/ ?>