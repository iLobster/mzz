<?php
            $baseresolver = new compositeResolver();
            $baseresolver->addResolver(new appFileResolver());
            $baseresolver->addResolver(new sysFileResolver());

            $resolver = new compositeResolver();
            $resolver->addResolver(new classFileResolver($baseresolver));
            $resolver->addResolver(new moduleResolver($baseresolver));
            $resolver->addResolver(new configFileResolver($baseresolver));
            $resolver->addResolver(new libResolver($baseresolver));
            $cachingResolver = new cachingResolver($resolver);

            fileLoader::setResolver($cachingResolver); // ��������� ���������
            
            fileLoader::load('exceptions/init'); // �������������
?>