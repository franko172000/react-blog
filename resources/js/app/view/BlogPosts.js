import Page from "../components/Page";
import {useEffect, useState} from "react";
import Loader from "../components/Loader";
import Blog from "../components/Blog";
import {getAllPosts} from "../services/requests";

const BlogPosts = ()=> {
    const [posts, setPosts] = useState();
    const [showLoader, setShowLoader] = useState();
    useEffect(async ()=>{
        await loadPosts();
    },[]);

    const handlePagination = async (page)=>{
        await loadPosts({
            page
        });
    }

    const loadPosts = async (params) => {
        setShowLoader(true);
        const res = await getAllPosts(params);
        setPosts(res.data);
        setShowLoader(false)
    }
    return (
        <>
            <Loader show={showLoader} />
            <Page
                title="Latest Posts">
                <div className="masonry-filter-container d-flex align-items-center">
                    <span>Category:</span>
                    <div className="masonry-filter-holder">
                        <div className="masonry__filters" data-filter-all-text="All Categories"></div>
                    </div>
                </div>
                <hr />
                <Blog onPaginationClick={handlePagination} posts={posts} />
            </Page>
        </>
    )
}

export default BlogPosts;
