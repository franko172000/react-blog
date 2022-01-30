const BlogCard = ()=> {
    return(
        <div className="masonry__container row">
            <div className="masonry__item col-lg-4 col-md-6">
                <article className="feature feature-1">
                    <div className="feature__body boxed boxed--border">
                        <span>May 25th 2016</span>
                        <h5>A day in the life of a professional fitness blogger</h5>
                        <a href="#">
                            Read More
                        </a>
                    </div>
                </article>
            </div>
        </div>
    )
}

export default BlogCard;
