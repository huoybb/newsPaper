<?php

class FocusController extends \App\myPlugins\myController
{
    public function indexAction($page = 1)
    {

        $this->view->page = $this->getPaginator(Focus::find(['order'=>'id DESC']),20,$page);
        $this->view->focus = Focus::find(['order'=>'id DESC','limit'=>25]);

    }

    public function showAction(Focus $focus)
    {
        $this->view->focus = $focus;
    }

    public function addAction()
    {
        $data = $this->request->getPost();
        $data['page_id'] = $this->getPageIdFromUrl($data['url']);

        Focus::saveNew($data)->addMultTags($this->request->getPost('tags'));

        return $this->redirectBack();
    }

    public function deleteAction(Focus $focus)
    {
        $focus->delete();
        $this->redirectByRoute(['for'=>'focus.index']);
    }

    public function addTagAction(Focus $focus)
    {
        $tagName = $this->request->get('tag');
        $focus->addTag($tagName);
        return 'success';
    }
    public function addCommentAction(Focus $focus)
    {
        $data = $this->request->getPost();
        $focus->addComment($data);
        return 'success';
    }

    public function showTagsAction(Focus $focus)
    {
        $this->view->focus = $focus;
    }
    
    public function deleteTagAction(Focus $focus, Tags $tag)
    {
        $tag->deleteTaggable($focus);
        return $this->redirectBack();
    }
    





    private function getPageIdFromUrl($url)
    {
        if (preg_match('%http://newspaper.zhaobing/issues/([0-9]+)/page/([0-9]+)%sm', $url, $regs)) {
            $issue = $regs[1];
            $page_num = $regs[2];
            $page = Pages::findOrNewByPageNumAndIssue($issue,['page_num'=>$page_num]);
            return $page->id;
        }
        throw new Exception('没有找到对应的page_id');
    }
}

