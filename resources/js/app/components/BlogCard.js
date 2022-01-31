const BlogCard = ({post})=> {
    return(
        <div className="masonry__item col-lg-4 col-md-6">
            <article className="feature feature-1">
                <div className="feature__body boxed boxed--border">
                    <span>{post.publicationDate}</span>
                    <h5>{post.title}</h5>
                    <a href="#">
                        Read More
                    </a>
                </div>
            </article>
        </div>
    )
}

export default BlogCard;
